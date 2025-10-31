// Frontend/js/controllers/bookingController.js 

import * as bookingService from '../services/bookingController.js';
import Booking from '../models/Book.js';
import * as bookingView from '../views/bookingPage.js';
import { validateBookingForm } from '../utils/validation.js';

/* Load all booking */
export async function loadBooking() {
    try {
        const bookingData = await bookingService.getAllBookings();
        const bookings = bookingData.map(Booking.fromJSON);
        bookingView.renderBookingList(bookings);
    } catch (err) {
        console.error('Error loading bookings:', err);
        bookingView.showError('Failed to load booking list.');
    }
}

/* Add new booking */
export async function addBooking(formData) {
    try {
        if (!validateBookingForm(formData)) {
            bookingView.showError('Please fill in all required fields.');
            return;
        }
        const newBooking = new Booking(formData);
        const saveData = await bookingService.createBooking(newBooking.toJSON());
        const saveBooking = Booking.fromJSON(saveData);

        bookingView.addBookingToList(saveBooking);
    } catch (err) {
        console.error('Error adding booking:', err);
        bookingView.showError('Failed to add booking');
    }
}

/* Delete a booking */
export async function removeBooking(id) {
    try {
        await bookingService.deleteBooking(id);
        bookingView.removeBookingFromDOM(id);
    } catch (err) {
        console.error('Error deleting booking:', err);
        bookingView.showError('Failed to delete booking.');
    }
}

/* Update a booking */
export async function updateBooking(id, updateData) {
    try {
        if (!validateBookingForm(updateData)) {
            bookingView.showError('Please provide valid booking details.');
            return;
        }

        const updateData = await bookingService.updateBooking(id, updateData);
        const updateBooking = Booking.fromJSON(updateData);
        await loadBooking(); // refresh List
    } catch (err) {
        console.error('Error updating booking:', err)
        bookingView.showError('Failed to update booking');
    }
}