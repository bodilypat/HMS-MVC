document.addEventListener('DOMController', () => {
	const form = document.getElementById('booking-form');
	const roomSelect = document.getElementById('room-type-select');
	const confirmation = document.getElementById('confirmatiion');
	const confirmationDetails = document.getElementById('confirmation-details');
	
	/* Load room type */
	apiRequest('room-types')
		then(data => {
			data.forEach(room => {
				const option = document.createElement('option');
				option.value = room.id;
				option.textContent = ${room.name} (${room.price}/night)';
				roomSelect.appendChild(option);
			});
		});
		.catch(err => {
			alert('Failed to load room types');
		});
		
		/* Handle booking submission */
		form.addEventListener('submit', async (e) => {
			e.preventDefault();
			const formData = new FormData(form);
			const payload = Object.fromEntries(formData.entries());
			
			try {
				const result = await apiRequest('book-room', 'POST', payload);
				form.classlist.add('hidden');
				confirmation.classlist.remove('hidden');
				confirmationDetails.textContent = 'Booking ID: ${result.booking_id} | Guest: ${payload.guest_name}';
			} catch (err) {
				alert("Booking failed. please try again.');
			}
		});
)};

