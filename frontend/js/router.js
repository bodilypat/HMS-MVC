// js/router.js
// Improved SPA router: caching, dynamic module imports with lifecycle hooks,
// link interception, 404/default route support, and safer navigation handling.

const Router = (() => {
    const SPA_MODE = true;
    const APP_CONTAINER_ID = "app";

    // Route configuration: add "*" for 404 or "" for default if desired
    const routes = {
        "/dashboard": {
            view: "/pages/dashboard/index.html",
            script: "/pages/dashboard/dashboard.js"
        },
        "/rooms": {
            view: "/pages/rooms/room.html",
            script: "/pages/rooms/rooms.js"
        },
        "/bookings": {
            view: "/pages/bookings/booking.html",
            script: "/pages/bookings/bookings.js"
        },
        "/guests": {
            view: "/pages/guests/guest.html",
            script: "/pages/guests/guests.js"
        },
        "/settings": {
            view: "/pages/settings/setting.html",
            script: "/pages/settings/settings.js"
        },
        // optional fallback 404 route
        "*": {
            view: "/pages/404.html"
        }
    };

    const viewCache = new Map();       // path -> html
    const moduleCache = new Map();     // scriptSrc -> Promise<module>
    let currentModule = null;          // last loaded module object
    let subscribers = new Set();

    function normalizePath(path) {
        if (!path) return "/";
        try {
            // If a full URL is passed, extract pathname
            const url = new URL(path, location.origin);
            return url.pathname || "/";
        } catch {
            return path.startsWith("/") ? path : "/" + path;
        }
    }

    function getRoute(path) {
        path = normalizePath(path);
        return routes[path] || routes["*"] || null;
    }

    async function fetchView(viewUrl) {
        if (viewCache.has(viewUrl)) return viewCache.get(viewUrl);
        const res = await fetch(viewUrl, {cache: "no-store"});
        if (!res.ok) throw new Error(`Failed to load view: ${viewUrl} (${res.status})`);
        const html = await res.text();
        viewCache.set(viewUrl, html);
        return html;
    }

    async function importModule(src) {
        if (!src) return null;
        if (moduleCache.has(src)) return moduleCache.get(src);
        // Save the promise immediately to dedupe concurrent imports
        const promise = (async () => {
            // Resolve to absolute URL to avoid relative import issues
            const resolved = new URL(src, location.origin).href;
            const mod = await import(resolved);
            return mod;
        })();
        moduleCache.set(src, promise);
        return promise;
    }

    async function loadView(path, options = {replaceHistory: false}) {
        const normalized = normalizePath(path);
        const route = getRoute(normalized);
        if (!route) {
            console.error("No route and no fallback route configured for:", normalized);
            return;
        }

        const container = document.getElementById(APP_CONTAINER_ID);
        if (!container) {
            console.error(`Container not found: ${APP_CONTAINER_ID}`);
            return;
        }

        try {
            // Run cleanup on previous module if provided
            if (currentModule && typeof currentModule.cleanup === "function") {
                try { currentModule.cleanup(); } catch (e) { console.warn("Module cleanup error:", e); }
            }
            currentModule = null;

            // Load and inject view HTML (cached)
            if (route.view) {
                const html = await fetchView(route.view);
                container.innerHTML = html;
            } else {
                container.innerHTML = "";
            }

            // Load module (ES module). If module exports init(container, params), call it.
            if (route.script) {
                const mod = await importModule(route.script);
                currentModule = mod || null;
                if (mod && typeof mod.init === "function") {
                    try { await mod.init(container, {path: normalized}); } catch (e) { console.warn("Module init error:", e); }
                }
            }

            // Notify subscribers
            subscribers.forEach(fn => {
                try { fn({path: normalized, route}); } catch (e) { console.warn("Subscriber error:", e); }
            });

            // Title update if provided by route or module
            if (route.title) document.title = route.title;
            else if (currentModule && typeof currentModule.title === "string") document.title = currentModule.title;

            // History state
            const state = {path: normalized};
            if (SPA_MODE) {
                if (options.replaceHistory) history.replaceState(state, "", normalized);
                else history.pushState(state, "", normalized);
            }
        } catch (err) {
            console.error("Router loadView error:", err);
            // Minimal UX fallback: show a simple error inside container
            container.innerHTML = `<div style="padding:20px;color:#900">Error loading page.</div>`;
        }
    }

    function navigate(path, opts = {}) {
        const normalized = normalizePath(path);
        if (!SPA_MODE) {
            location.href = normalized;
            return;
        }
        // avoid unnecessary reload if same path
        if (normalizePath(window.location.pathname) === normalized && !opts.force) {
            return;
        }
        loadView(normalized, {replaceHistory: !!opts.replace});
    }

    function handlePopState(e) {
        if (!SPA_MODE) return;
        const path = e.state && e.state.path ? e.state.path : window.location.pathname;
        loadView(path, {replaceHistory: true});
    }

    // Intercept same-origin links to enable SPA navigation.
    function linkInterceptor(e) {
        if (!SPA_MODE) return;
        // Only left-click without modifiers
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        let el = e.target;
        while (el && el.nodeName !== "A") el = el.parentElement;
        if (!el || !el.href) return;
        // External or hash-only links should not be intercepted
        const url = new URL(el.href, location.origin);
        if (url.origin !== location.origin) return;
        // allow anchors for the same page to behave normally
        if (url.pathname === window.location.pathname && url.hash) return;
        // Optional: allow opt-out via data-routing="false"
        if (el.dataset && el.dataset.routing === "false") return;

        e.preventDefault();
        navigate(url.pathname + url.search + url.hash);
    }

    // Simple subscribe/unsubscribe for route changes
    function onRouteChange(fn) {
        subscribers.add(fn);
        return () => subscribers.delete(fn);
    }

    // Initialize listeners
    window.addEventListener("popstate", handlePopState);
    document.addEventListener("click", linkInterceptor);

    // Optionally auto-load on first run (load current pathname)
    if (SPA_MODE) {
        // Use replace to set initial state
        loadView(window.location.pathname, {replaceHistory: true});
    }

    return {
        getRoute: (p) => getRoute(p),
        navigate,
        loadView,
        importModule,      // exported for advanced use
        onRouteChange: onRouteChange,
        _clearCache: () => { viewCache.clear(); moduleCache.clear(); } // testing helper
    };
})();