// Frontend/js/services/guestService.js

const BASE_URL = 'https://sunshine-hotel.com/api/guests'; 

export async function getAllGuest() {
    try { 
        const response = await fetch(BASE_URL);
        if (!response.ok) throw new Error (`Failed to fetch guests: ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error('Error fetching guests:', error);
        throw error;
    }
}

/* Create a new guest */
export async function createGuest(gestData) {
    try {
        const response = await fetch(BASE_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json'},
            body: JSON.stringify(guestData)
        });
        if (!response.ok) throw new Error(`Failed to create guest: ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error('Error creating guest:', error);
        throw error;
    }
}

/* Update a guest */
export async function updateGuest(id, guestData) {
    try {
        const response = await fetch(`${BASE_URL}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(guestData)
        });
        if (!response.ok) throw new Error('Failed to update guest: ${response.status}');
        return await response.json();
    } catch (error) {
        console.error('Error updating guest:', error);
        throw error;
    }
}

/* Delete a guest */
export async function deleteGuest(id) {
    try {
        const response = await fetch(`${BASE_URL}/${id}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Failed to delete guest: ${response.status}');
        return true;
    } catch (error) {
        console.error('Error deleting guest:', error);
        throw error;
    }
}

/* Optional Search guests by name or email */
export async function searchGuest(query) {
    try {
        const response = await fetch(`${BASE_URL}?search=${encodeURIComponent(query)}`);
        if (!response.ok) throw new Error(`Search failed: ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error('Error searching guests:', error);
        throw error;
    }
}