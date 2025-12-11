//js/modules/dashboard.module.js

import { getAllRooms, getAvailableRooms } from "../services/rooms.service.js";
import { getAllBooking, getRecentBooking } from "../services/booking.service.js";
import { getAllGuests } from "../services/guests.service.js";
import { formatDate } from "../utils.js";

/* Initialize Dashboard
   loads stats, recent bookings, and updates UI components
 */
export async function initDashboard() {
    try {
        const rooms = await getAllRooms();
        const availableRooms = await getAvailableRooms();
        const bookings = await getAllBooking();
        const recentBookings = await getRecentBooking();
        const guests = await getAllGuests();

        loadStatisticsCards({ rooms, availableRooms, bookings, recentBookings, guests });
        loadRecentBookings(recentBookings);

    } catch (error) {
        console.error('Error initializing dashboard:', error);
    }
}

/* Load Statistics Cards
   Updates all dashboard stats cards
 */
export function loadStatisticsCards({ rooms = [], availableRooms = [], bookings = [], recentBookings = [], guests = [], revenue = 0 }) {
    try {
        const setText = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.textContent = value;
        };
        setText('totalRooms', rooms.length);
        setText('availableRooms', availableRooms.length);
        setText('occupiedRooms', rooms.length - availableRooms.length);
        setText('totalBookings', bookings.length);
        setText('todayCheckins', bookings.filter(b => {
            const d = new Date(b.checkin);
            const today = new Date();
            return  d.getFullYear() === today.getFullYear() &&
                    d.getMonth() === today.getMonth() &&
                    d.getDate() === today.getDate();
        }).length);
        setText("totalCustomers", guests.length);
        setText("totalRevenue", bookings.reduce((sum, b) => sum + (b.amount || 0), 0));
    } catch (error) {
        console.error('Error loading statistics cards:', error);
    }
}


/* Load Recent Bookings Table
   Renders the last 20 bookings in the dashboard and updates table
 */
export function loadRecentBookings(bookings = []) {
    try {
        const tbody = document.getElementById('recentBookingsTable');
        if (!tbody) return;

        tbody.innerHTML = bookings.slice(0, 20)
            .map(b => {
                const guest = b.guestName || b.guest || '-';
                const room = b.roomNumber || b.room || '-';
                const checkin = b.checkin ? formatDate(b.checkin) : '-';
                const checkout = b.checkout ? formatDate(b.checkout) : '-';
                const status = b.status || '-';
                const total = b.total != null ? `$${b.total.toLocaleString()}` : '$0';
                return `<tr data-booking-id="${b.id || ''}">
                    <td>${guest}</td>
                    <td>${room}</td>
                    <td>${checkin}</td>
                    <td>${checkout}</td>
                    <td>${status}</td>
                    <td style="text-align:right">${total}</td>
                </tr>`;
            }).join('');
    } catch (error) {
        console.error('Error loading recent bookings:', error);
    }
}
