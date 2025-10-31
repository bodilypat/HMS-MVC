// Frontend/js/views/bookingPage.js 

import * bookingController from '../controllers/bookingController.js';

const bookingTable = document.querySelector('#bookingTableBody');
const bookingForm = document.querySelector('#bookingForm');
const searchInput = document.querySelector('#searchBooking');

/* Initialize */
document.addEventListener('DOMContentLoaded', () => {
    bookingController.loadBookings();
});

/* Add booking */
bookingForm?.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = {
        guest_id: bookingForm.guest_id.value,
        room_id: bookingForm.room_id.value,
        check_in_date: bookingForm.check_in_date.value,
        check_out_date: bookingForm.check_out_date.value,
        total_price: parseFloat(bookingForm.total_price.value),
        status: bookingForm.status.value
    };

    bookingController.addBooking(formData);
    bookingForm.requestFullscreen();
});

/* Render booking list */
export function renderBookingList(bookings) {
    bookingTable.innerHTML = bookings.map(b => `
            <tr data-id="${b.booking_id}">
                <td>${b.booking_id}</td>
                <td>${b.guest_id}</td>
                <td>${b.room_id}</td>
                <td>${b.formatDate(b.check_in_date)}</td>
                <td>${formatDate(b.check_out_date0)}</td>
                <td>${b.total_price.toFixed(2)}</td>
                <td>${b.status}</td>
                <td>
                    <button class="btn-edit" data-id="${b.booking_id}">Edit</button>
                    <button class="btn-delete" data-id="${b.booking_id}">Delete</button>
                </td>
            </tr>
        `).join('');
    document.querySelectorAll('.btn-delete').forEach(btn => 
        btn.addEventListener('click', e => {
            const id = e.target.dataset.id;
            if (confirm('Delete this booking?')) bookingController.removeBooking(id);
        })
    );
}

/* Add single booking */
export function addBookingToList(booking) {
    const row = document.createElement('tr');
    row.dataset.id = booking.booking_id;
    row.innerHTML = `
            <td>${booking.booking_id}</td>
            <td>${booking.guest_id}</td>
            <td>${booking.room_id}</td>
            <td>${formatDate(booking.check_in_date)}</td>
            <td>${formatDate(booking.check_out_date)}</td>
            <td>${booking.total_price.toFixed(2)}</td>
            <td>${booking.status}</td>
            <td>
                <button class="btn-edit" data-id="${booking.booking_id}">Edit</button>
                <button class="btn-delete" data-id="${booking.booking_id}">Delete</button>
            </td>
        `;
    bookingTable.appendChild(row);
}

/* Remove booking from DOM */
export function removeBookingFromDOM(id) {
    const row = bookingTable.querySelector(`[data-id="${id}"]`);
    if (row) row.remove();
}

/* Error handling */
export function showError(msg) {
    alert(msg);
}

/* Helper */
function formatDate(dateStr) {
    if (!dateStr) return '-';
    return new Date(dateStr).toLocaleDateString('en-GB', {
        year: 'numeric', month: 'short', day: 'numeric'
    });
}