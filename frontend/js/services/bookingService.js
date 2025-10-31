// Frontend/js/services/bookingService.js 

const BASE_URL = '/api/bookings';

export async function getAllBooking() {
    const response = await fetch(BASE_URL);
    if (!response.ok) throw new Error('Failed to fetch bookings');
    return response.json();
}
export async function createBooking(data) {
    const response = await fetch(BASE_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify.stringify(data)
    });
    if (!response.ok) throw new Error('Failed to create booking');
    return response.json();
}

export async function updateBooking(id, data) {
    const response = await fetch(`${BASE_URL}/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    if (!response.ok) throw new Error('Failed to update booking');
    return response.json();
}

export async function deleteBooking(id) {
    const response = await fetch(`${BASE_URL}/${id}`, { method: 'DELETE' });
    if (!response.ok) throw new Error('Failed to delete bppking');
    return response.json();
}