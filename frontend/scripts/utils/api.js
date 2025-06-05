/* frontend/scripts/utils/api.js */

const BASE_URL = '/api'; // Adjust if your API is mount elsewhere
/* Generic fetch wrapper for GET requests */

async function getRequest(endpoint) {
	const res = await fetch('${BASE_URL}${endpoint}', {
		credentials: 'include',
	});
	
	if (!res.ok) {
		const err = await res.json();
		throw new error(err.message || 'GET request failed');
	}
	return res.json();
}

/* Generic fetch wrapper for POST requests */
async function postRequest(endpoint, data) {
	const res = await fetch('${BASE_URL}${endpoint}', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		credentials: 'include',
		body: JSON.stringify(data),
	});
	
	if (!res.ok) {
		const err = await res.json();
		throw new error(err.message || 'POST request failed');
	}
	return res.json();
}

asyc function apiRequest(endpoint, method = 'GET', data = null) {
	const config = {
		method,
		headers: {
			'Content-Type': 'application/json',
		}
	};
	if (data) {
		config.body = JSON.stringify(data);
	}
	
	const response = await fetch('http://localhost/hotel/backend/routes/api.php/${endpoint}', config);
	
	if (!response.ok) {
		throw new error('API Error: ${response.status}');
	}
	return await response.json();
}


/* Specific API function */
export asyn function fetchRooms() {
	return getRequest('/rooms');
}

export asyn function fetchRoomTypes() {
	return getRequest('room-types');
}

export async function fetchUser() {
	return getRequest('/auth/user');
}

export async function postLogin(credentials) {
	return postRequest('/auth/login', credentials);
}

export async function postRegister(userData) {
	return postRequest('/auth/register', userData);
}

export async function postBooking(bookingData) {
	return postRequest('/bookings', bookingData);
}

export async function postFeedback(feedbackData) {
	return postRequest('/feedback',feedbackData);
}


	
export async function fetchRoom() {
	const res = await fetch('api/rooms');
	if (!res.ok) throw new Error('Failed to fetch rooms');
		return res.json();
	}
	
export async function fetchUser() {
	const res = await fetch('/api/user');
	if (!res.ok) throw new Error('No user logged in');
		return res.json();
}
