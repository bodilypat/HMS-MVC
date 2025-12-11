//pages/dashboard/dashboard.js 
(() => {
    'use strict';

    /* Selectors */
    const selectors = {
        totalRooms: '#totalRooms',
        availableRooms: '#availableRooms',
        occupiedRooms: '#occupiedRooms',
        totalBookings: '#totalBookings',
        todayCheckins: '#todayCheckins',
        revenue: '#totalRevenue',
        bookingsTbody: '#recentBookingsTable',
        searchInput: '#searchInput',
        refreshButton: '#refreshButton',
        logoutButton: '#logoutButton',
        lastUpdated: '#lastUpdated'
    };

    /* API Endpoints */
    const apiEndpoints = {
        dashboard: '/api/dashboard',
        rooms: '/api/rooms',
        booking: '/api/booking'
    };

    /* Helpers */
    const $ = (selector) => document.querySelector(selector);
    const $$ = (selector) => document.querySelectorAll(selector);

    const formatCurrency = (value = 0) =>
        new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);

    const escapeHtml = (str = '') =>
        String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    const isToday = (date) => {
        const today = new Date();
        const d = new Date(date);
        return today.toDateString() === d.toDateString();
    };

    /* Fetching JSON Wrapper */
    async function fetchJson(url, options = {}) {
        const response = await fetch(url, options);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    }

    /* Render Stats */
    function renderStats(stats = {}) {
        const setText = (selector, value) => {
            const el = $(selector);
            if (el) el.textContent = value;
        };

        setText(selectors.totalRooms, stats.totalRooms || 0);
        setText(selectors.availableRooms, stats.availableRooms || 0);
        setText(selectors.occupiedRooms, stats.occupiedRooms || 0);
        setText(selectors.totalBookings, stats.totalBookings || 0);
        setText(selectors.todayCheckins, stats.todayCheckins || 0);
        setText(selectors.revenue, formatCurrency(stats.revenue || 0));
    }

    /* Render Recent Bookings */
    function renderBookings(bookings = []) {
        const tbody = $(selectors.bookingsTbody);
        if (!tbody) return;

        tbody.innerHTML = bookings.slice(0, 20)
            .map(b =>
                `<tr data-booking-id="${escapeHtml(b.id || '')}">
                <td>${escapeHtml(b.guest || b.guestName || '-')}</td>
                <td>${escapeHtml(b.roomNumber || (b.room?.number || '-'))}</td>
                <td>${escapeHtml(b.checkin ? new Date(b.checkin).toLocaleDateString() : '-')}</td>
                <td>${escapeHtml(b.checkoutDate ? new Date(b.checkoutDate).toLocaleDateString() : '-')}</td>
                <td>${escapeHtml(b.status || b.status || '-')}</td>
                <td style="text-align:right">${escapeHtml(b.amount ? formatCurrency(b.amount) : formatCurrency(0))}</td>
            </tr>`
            )
            .join('');
    }

    /* Load dashboard data */
    async function loadDashboard() {
        try {
            let data;
            try {
                // Attempt aggregated endpoint first
                data = await fetchJson(apiEndpoints.dashboard);
            } catch (error) {
                console.warn('Aggregated endpoint failed, falling back to individual endpoints:', error);
                const [rooms, bookings = []] = await Promise.all([
                    fetchJson(apiEndpoints.dashboard + '/stats'),
                    fetchJson(apiEndpoints.dashboard + '/recentBookings')
                ]);
                data = {
                    rooms,
                    bookings,
                    stats: {
                        totalRooms: rooms.length,
                        availableRooms: rooms.filter(r => r.status === 'available').length,
                        occupiedRooms: rooms.filter(r => r.status === 'occupied').length,
                        totalBookings: bookings.length,
                        todayCheckins: bookings.filter(b => isToday(b.checkinDate)).length,
                        revenue: bookings.reduce((sum, b) => sum + (b.amount || 0), 0)
                    }
                };
            }
            renderStats(data.stats);
            renderBookings(data.recentBookings);

            const lastUpdatedEl = $(selectors.lastUpdated);
            if (lastUpdatedEl) lastUpdatedEl.textContent = new Date().toLocaleString();

        } catch (error) {
            console.error('Error loading dashboard:', error);
            const lastUpdatedEl = $(selectors.lastUpdated);
            if (lastUpdatedEl) lastUpdatedEl.textContent = 'Error loading data';
        }
    }

    /* Setup Event Listeners */
    function setupListeners() {
        const searchEl = $(selectors.searchInput);
        if (searchEl) searchEl.addEventListener('input', (event) => filterBookings(event.target.value));

        const refreshEl = $(selectors.refreshButton);
        if (refreshEl) refreshEl.addEventListener('click', () => loadDashboard());

        const logoutEl = $(selectors.logoutButton);
        if (logoutEl) {
            logoutEl.addEventListener('click', async (e) => {
                e.preventDefault();
                try {
                    await fetchJson(apiEndpoints.logout, { method: 'POST' });
                    window.location.href = '/login';
                } catch (error) {
                    console.error('Logout failed:', error);
                }
            });
        }
    }

    /* Filter Bookings Table */
    function filterBookings(query = '') {
        const tbody = $(selectors.bookingsTbody);
        if (!tbody) return;

        query = query.toLowerCase();
        Array.from(tbody.rows).forEach(row => {
            const guestName = row.cells[0].textContent.toLowerCase();
            const roomNumber = row.cells[1].textContent.toLowerCase();
            row.style.display = guestName.includes(query) || roomNumber.includes(query) ? '' : 'none';
        });
    }

    /* Initialize Dashboard Page */
    function init() {
        setupListeners();
        loadDashboard();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    /* Expose for Debugging */
    window.dashboard = {
        loadDashboard,
        filterBookings
    };

})();
