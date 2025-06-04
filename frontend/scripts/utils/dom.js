/* frontend/scripts/utils/api.js */
export function renderRoomCards(rooms) {
	const container = document.querySelector('#roomContainer');
	if (!container) return;
	
	container.innerHTML = '';
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

export function showNotification(message, type = 'info') {
	alert('${type.toUpperCase()}: ${message}'); // Replace with toast/snackbar logic if needed
}

