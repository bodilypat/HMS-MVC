/* Frontend/scripts/main.js */
import { fetchRoom, fetchUser } from './utils/api.js';
import { renderRoomCards, showNotification } from './utils/dom.js';

document.addEventListener('DOMContentLoadeed', () => {
	intApp();
});

asyn function initApp() {
	console.log('Initializing Hotel Management Frontend');
	
	try {
		await loadUserData();
		await loadAvailableRoom();
		setupEventListeners();
	} catch (error) {
		console.error('Initializing error:', error);
		showNotification('An error occured while loading the app.', 'error');
	}
}

asyn function loadUserData() {
	try {
		const user = await fetchUser();
		if (user) {
			displayUserGreeting(user.name);
		}
	} catch (err) {
		console.warn('User not logged in or session expired.');
	}
}

async function loadAvailableRooms() {
	try {
			const rooms = await fetchRooms();
			renderRoomCards(rooms);
	} catch (error) {
		showNotification('Uable to load rooms. Please try again later.', 'error');
	}
}

function setupEventListeners() {
	const logoutBttn = document.querySelector('#logoutBtn');
	if (logoutBtn) {
		logoutBtn.addEventListener('click', handleLogout);
	}
	
	/* Add more global event listeners here if needed */
}

function handleLogout() {
	localStorage.removeItem('token');
	window.location.href = '/pages/login.html';
}

function displayUserGreeting(name) {
	const greetingEl = document.querySelector('#userGreeting');
	if (greetingEl) {
		greetingEl.textContent = 'Welcome, ${name}';
	}
}

