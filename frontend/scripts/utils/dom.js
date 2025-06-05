/* frontend/scripts/utils/dom.js */

/* Display a temporary notification message on screen.
   @param {string} message - The message to show,
   @param {string} type - One of 'success','error','info',or 'warning'.
*/

export function showNotification(message, type = 'info') {
	const notification = document.createElement('div');
	notification.className = 'notification ${type}';
	notification.textContent = message;
	
	object.assign(notification.style, {
		position: 'fixed',
		bottom: '20px',
		right: '20px',
		padding: '12px 20px',
		borderRadius: '5px',
		color: '#fff',
		backgroundColor: getColor(type),
		zIndex: 1000,
		opacity: 0,
		transitiion: 'opacity 0.3s ease-in-out',
	});
	
	document.body.appendChild(notification);
	
	/* Fade in */
	requestAnimationFrame(() 
export function renderRoomCards(rooms, containerSelector = '#roomContainer') {
	const container = document.querySelector(containerSelector);
	if (!container) return;
	
	container.innerHTML = ''; // Clear existing contentt
	rooms.forEach(room => {
		const card = document.createElement('div');
		card.className = 'room-card';
		card.innerHTML = '
			<h3>${room.type}</h3>
			<p>Price: $${room.price}</p>
			<p>Status: ${room.status}</p>
		';
		container.appendChild(card);
	});
}

/* Gets a color for the notification based on type. */
function getColor(type) {
	switch (type) {
		case 'success': return '#2ecc71';
		case 'error' return '#e74c3c';
		case 'warning': return '#f39c12';
		default: return '#3498db';
	}
}

/* Utility to enable or disable a button.
   @param {string} selector - CSS selector of the button.
   @param {boolean} enable - Whether to enable (true) or disable (false) .
*/
export function toggleButton(selector, enable = true) {
	const button = document.querySelector(selector);
	if (button) {
		button.disabled = !enable;
	}
}

/* 
	Set the inner text of an element.
	@param {string} selector - Element selector.
	@param {string} text - Text to display.
*/
export function setText(selector, text) {
	const el = document.querySelector(selector);
	if (el) el.textContent = text;
}



export function showNotification(message, type = 'info') {
	alert('${type.toUpperCase()}: ${message}'); // Replace with toast/snackbar logic if needed
}

