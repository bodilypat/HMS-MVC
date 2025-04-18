/* Base URL to your API*/
const apiUrl = 'api/guests.php';

/* Fetch all guest */
function fetchGuest() {
	fetch(apiUrl) {
		.then(res => res.json()) 
		.then(data => {
			console.log('guests:' , data);
			displayGuests(data);
		});
		.catch(error => console.error("Error fetching guests: ', error));
	}
	
	/* Create a new Guest */
	function createGuest(guestData) {
		fetch(apiUrl , {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(guestData)
		})
		.then(res => res.json())
		.then(result => {
			console.log('Guest created ', result);
			// Refresh List
			fetchGuests(); 
		})
		.catch(error => console.error('Error creting guests: ', error));
	}
	
	/* Update Guest */
	function updateGuest(guestId, updateData) {
		fetch('${apiUrl}? id=${guestId, updateData}', {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(updateData)
		})
		.then(res => res.json()) 
		.then(result => {
			console.log('Cuest updated: ', result);
			fetchGuests();
		})
		.catch(err => console.error('Error updating guest: ', err);
	}
	
	/* Delete Guest in a table */
	function deleteGuest(guestId) {
		if (!confirm("Delete this guest?")) return;
		
		fetch('${apiUrl}? Id=${guestId}', {
			method: 'DELETE'
		})
		.then(res => res.json())
		.then(result => {
			console.log('Guest deleted: ', result0;
			fetchGuest();
		})
		.catch(err => console.error('Error deleting guest:', err));
	}
	
	/* Display Guest in a table */
	function displayGuests(guests) {
		const tbody = document.getElementById('guestTableBody');
		tbody.innerHTML = '';
		
		guests.forEach(g => {
			const tr = document.createElement('tr');
			tr.innerHTML = '
				<td>${g.guest_id}</td>
				<td>${g.first_name} ${g.last_name}</td>
				<td>${g.email}</td>
				<td>${g.phone_number || '-'}</td>
				<td>${g.nationality || '-'}</td>
				<td>${g.check_in_date || '-'}</td>
				<td>${g.check_out_date || '-'}></td>
				<td>
					<button onclick="editGuest(${g.guest_id})">Edit</button>
					<button onclick="deleteGuest(${g.guest_id})">Delete</button>
				</td>
			';
			tbody.appendChild(tr);
		});
	}
	
	/* Edit Guest */
	function editGuest(guestId) {
		const guest = guestData.find(g => g.guest_id === guestId);
		if (!guest) return alert("Guest not found.");
		
		const firstName = prompt("First Name: ", guest.first_name);
		const lastName = prompt("Last Name: ", guest.last_name);
		const email = prompt("Email: ", guest.email);
		const phone = prompt("Phone Number: ", guest.phone_number);
		const nationality = prompt("Nalitionality: ", guest.nationality);
		const checkIn = prompt("Check-in Date (YYYY-MM-DD):", guest.check_in_date);
		const checkOut = prompt("Check-out Date(YYYY-MM-DD): ", guest.check_out_data);
		
		const updatedGuest = {
			...guest,
			first_name: firstName,
			last_name: lastName,
			email: email,
			phone_number: phone,
			nationality: nationality,
			check_in_date: checkIn,
			check_out_date: checkOut
		};
		updateGuest(guestId, updatedGuest);
	}
	
			
		
			
