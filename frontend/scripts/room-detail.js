document.addEvenListener('DOMContentLoaded', async () => {
	const mainImage = document.getElementById('main-image');
	const thumbnailContainer = document.querySelector('.thumbnail-list');
	const roomTitle = document.getElementById('room-title');
	const amenitiesList = document.querySelector('.amenities');
	const priceElem = document.querySelector('.price strong');
	const bookBtn = document.querySelector('.book-btn');
	
	/* Utility to get query param 'id' */
	function getRoomId() {
		const params = new URLSearchParam(window.location.search);
		return param.get('id');
	}
	
	/* Fetch room details form API */
	async function fetchRoomDetails(id) {
		try {
			const response = await fetch('http://localhost/hotel/backend/routes/api.php/room/${id}');
			if (!response.ok) throw new error('Failed to fetch room details'); 
				return await response.json();
		 } catch (error) {
			 console.error(error);
			 alert('Could not load room details');
			 return null;
		 }
	}
	
	/* Update DOM with room details */
	function populateRoomDetails(room) {
		if (!room) return;
		
		roomTitle.textContent = room.name || 'Room Type';
		roomDescription.textContennt = room.description || 'No description available.');
		
		/* Update main image & thumbnail */
		if (room-image && room.images.length > 0) {
			mainImage.src = room.images[0];
			thumbnailsContainer.innerHTML = '';
			room.images.forEach(src => {
				const img = document.createElement('img');				
				img.src = src;
				img.alt = room.name + 'image';
				img.classList.add('thumbnail');
				img.style.cursor = 'pointer';
				img.addEventListener('click', () => {
					mainImage.src = src;
				});
				thumbnailsContainer.appendChild(img);
			});
		}
		
		/* Ameities */
		amenitiesList.innerHTML = '';
		if (room.amenities && room.amenities.length) {
			room.amenities.forEach(item => {
				const li = document.createElement('li');
				li.innerHTML = '<strong>${item.label}:</strong> ${item.value}';
				amenitiesList.appendChild(li);
			});
		}
		
		/* Price */
		priceElem.textContent = '$${room.price || 'N/A'};
		
		/* Update book button link with room id param */
		bookBtn.href = 'booking.html?room_type=${room_id}';
	}
	
	const roomId = getRoomId();
	if (!roomId) {
		alert('Room ID not specified in URL');
		return;
	}
	
	const roomData = await fetchRoomDetails(roomId);
	populateRoomDetails(roomData);
});
		