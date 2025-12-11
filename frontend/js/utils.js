// js/utils.js

/* Shortcut for querySelector */
export const $ = (selector, parent = document) =>
    typeof selector === 'string' ? parent.querySelector(selector) : selector || null;

/* Shortcut for querySelectorAll (returns Array) */
export const $$ = (selector, parent = document) =>
    Array.from((typeof selector === 'string' ? parent.querySelectorAll(selector) : selector) || []);

/* Event delegation
     container: Element or selector string
     options: { capture, once, passive } forwarded to addEventListener
*/
export function on(container, event, selector, handler, options = {}) {
    const root = typeof container === 'string' ? document.querySelector(container) : container;
    if (!root) return () => {};

    const listener = (e) => {
        const target = e.target && e.target.closest ? e.target.closest(selector) : null;
        if (target && root.contains(target)) {
            // attach currentTarget to mimic delegated element
            handler.call(target, Object.assign(e, { delegatedTarget: target }));
        }
    };

    root.addEventListener(event, listener, options);

    // return unsubscribe
    return () => root.removeEventListener(event, listener, options);
}

/* Simple, safer HTML sanitizer (no external libs)
     - Removes disallowed elements (script, style, iframe, object, embed, link)
     - Strips event-* attributes and javascript: URIs
     - Allows a conservative set of tags/attributes
*/
const ALLOWED_TAGS = new Set([
    'a', 'abbr', 'b', 'br', 'code', 'div', 'em', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
    'i', 'img', 'li', 'ol', 'p', 'pre', 'span', 'strong', 'table', 'tbody', 'thead',
    'td', 'th', 'tr', 'ul'
]);

const ALLOWED_ATTRS = new Set(['href', 'src', 'alt', 'title', 'width', 'height', 'colspan', 'rowspan']);

function isSafeUrl(val) {
    if (!val) return false;
    const trimmed = val.trim().toLowerCase();
    return !trimmed.startsWith('javascript:') && !trimmed.startsWith('data:text/html') && !trimmed.startsWith('vbscript:');
}

export function sanitizeHTML(dirty) {
    if (dirty == null) return '';
    const template = document.createElement('template');
    template.innerHTML = String(dirty);

    const walk = (node) => {
        if (node.nodeType === 1) { // Element
            const tag = node.tagName.toLowerCase();

            // Remove disallowed elements entirely
            if (!ALLOWED_TAGS.has(tag)) {
                node.remove();
                return;
            }

            // Clean attributes
            Array.from(node.attributes).forEach(attr => {
                const name = attr.name.toLowerCase();
                const value = attr.value;

                // remove event handlers and style and unknown attrs
                if (name.startsWith('on') || name === 'style' || !ALLOWED_ATTRS.has(name)) {
                    node.removeAttribute(attr.name);
                    return;
                }

                // href/src safety
                if ((name === 'href' || name === 'src') && !isSafeUrl(value)) {
                    node.removeAttribute(attr.name);
                }
            });
        } else if (node.nodeType === 8) {
            // remove comments
            node.remove();
            return;
        }

        // recurse on children after potential removal
        Array.from(node.childNodes).forEach(child => walk(child));
    };

    Array.from(template.content.childNodes).forEach(child => walk(child));
    return template.innerHTML;
}

/* DATE UTILITIES */
export function formatDate(date, locale = 'en-US', opts = {}) {
    const d = new Date(date);
    if (Number.isNaN(d.getTime())) return '';
    return d.toLocaleDateString(locale, Object.assign({
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }, opts));
}

export function isPastDate(date) {
    const d = new Date(date);
    return !Number.isNaN(d.getTime()) && d < new Date();
}

/* NUMBER / CURRENCY UTILITIES */
export function formatNumber(number, locale = 'en-US', options = {}) {
    const n = Number(number);
    if (!isFinite(n)) return '';
    return new Intl.NumberFormat(locale, options).format(n);
}

/* Format money with currency */
export function formatCurrency(amount, currency = 'USD', locale = 'en-US') {
    const n = Number(amount);
    if (!isFinite(n)) return '';
    try {
        return new Intl.NumberFormat(locale, { style: 'currency', currency }).format(n);
    } catch (e) {
        return n.toFixed(2);
    }
}

/* Generate unique ID: crypto-backed when available */
export function generateUniqueId(prefix = '_') {
    try {
        const array = new Uint32Array(2);
        if (typeof crypto !== 'undefined' && crypto.getRandomValues) {
            crypto.getRandomValues(array);
            return `${prefix}${(array[0] ^ array[1]).toString(36)}${Date.now().toString(36)}`.substr(0, 16);
        }
    } catch (e) { /* fallback */ }
    return `${prefix}${Math.random().toString(36).substr(2, 9)}`;
}

/* local storage utilities with safety */
export const storage = {
    set(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            return true;
        } catch (e) {
            // quota or disabled; fail silently
            return false;
        }
    },
    get(key, fallback = null) {
        try {
            const value = localStorage.getItem(key);
            if (value == null) return fallback;
            return JSON.parse(value);
        } catch (e) {
            return fallback;
        }
    },
    remove(key) {
        try {
            localStorage.removeItem(key);
            return true;
        } catch (e) {
            return false;
        }
    },
    clear() {
        try {
            localStorage.clear();
            return true;
        } catch (e) {
            return false;
        }
    }
};

/* MISC UTILITIES */
export function clamp(value, min, max) {
    return Math.min(max, Math.max(min, value));
}

export function debounce(fn, wait = 250) {
    let t;
    return function (...args) {
        clearTimeout(t);
        t = setTimeout(() => fn.apply(this, args), wait);
    };
}

export function throttle(fn, limit = 250) {
    let inThrottle;
    return function (...args) {
        if (!inThrottle) {
            fn.apply(this, args);
            inThrottle = true;
            setTimeout(() => (inThrottle = false), limit);
        }
    };
}

/* Create a status badge class name */
export function getStatusBadgeClass(status = '') {
    switch ((String(status) || '').toLowerCase()) {
        case 'active':
            return 'badge-success';
        case 'inactive':
            return 'badge-secondary';
        case 'pending':
            return 'badge-warning';
        case 'banned':
            return 'badge-danger';
        default:
            return 'badge-primary';
    }
}

export default {
    $,
    $$,
    on,
    sanitizeHTML,
    formatDate,
    isPastDate,
    formatNumber,
    formatCurrency,
    generateUniqueId,
    clamp,
    debounce,
    throttle,
    getStatusBadgeClass
};
