// Frontend/js/controllers/guestController.js

import * as guestService from '../services/guestService.js';
import Guest from '../models/Guest.js';
import * as guestView from '../views/guestPage.js';
import { validateGuestForm } from '../utils/validation.js';

/* Load all guest */
export async function loadGuests() {
    try {
        const guestData = await guestService.getAllGuests();
        const guests = guestsData.map(Guest.formJSON);
        guestView.renderGuestList(guests);
    } catch (error) {
        console.error('Error loading guests:', error);
        guestView.showError('Failed to load guest list.');
    }
}

/* Add a new guest */
export async function addGuest(formData) {
    try {
        /* Validate input data (optional utility function) */
        if (!validateGuestForm(formData)) {
            guestView.showError('Please fill in required fields correctly.')
            return;
        }

        const newGuest = new Guest(formData);
        const savedGuestData = await guestService.createGuest(newGuest.toJSON());
        const savedGuest = Guest.formJSON(savedGuestData);

        guestView.addGuestToList(savedGuest);
    } catch (error) {
        console.error('Error adding guest:', error);
        guestView.showError('Failed to add guest.');
    }
}

/* Delete a guest */
export async function removeGuest(id) {
    try {
        await guestService.deleteGuest(id);
        guestView.removeGuestFromDOM(id);
    } catch (error) {
        console.error('Error deleting guest:', error);
        guestView.showError('Failed to delete guest.')
    }
}

/* (Optional) Update guest details */
export async function updateGuest(id, updateData) {
    try {
        if (!validateGuestForm(updateData)) {
            guestView.showError('Please provide valid guest data.');
            return;
        }
        const updateGuestData = await guestService.updateGuest(id, updateData);
        const updateGuest = Guest.formJSON(updateGuestData);

        /* Reload or update the UI */
        loadGuests(); 
    } catch (error) {
        console.error('Error updating guest:', error);
        guestView.showError('Failed to update guest.')
    }
}