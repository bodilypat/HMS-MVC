/* Base URL to backend API */
const apiUrl = 'api/bookings.php';

/* Fetch all Bookings */
function fetchAllBookings() {
	fetch(apiUrl)
		.then(response => response.json())
		.then(daa => {
			console.log('All Bookings:', data);
			/* Function to show te data in a table */
			displayBooking(data);
		})
		.catch(error => {
			console.error('Error fetching booking:', error);
		});
}


/* create a new booking */
function createBooking(guestId, roomId, checkIn, checkOut, numberOfGuest, bookingStatus, paymentStatus, bookingSource, specialRequests) {
	const data = {
		guest_id: guestId,
		room_id = roomId,
		check_in: checkIn,
		check_out: checkOut,
		number_of_quests: numberOfGuests,
		booking_status: bookingStatus,
		payment_status: paymentStatus,
		booking_source: bookingSource,
		special_requests: specialRequests
	};
	fetch(apiUrl, {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify(data)
	})
	.then(response => response.json())
	.then(result => {
			console.log("Booking Create', result);
			/* Refresh List */
			fetchBookings();
	})
	.catch(err => console.error('Error creating booking:', err));
}

/* Display all bookings */
function displayBookings(bookings) {
	const tbody = document.getElementById('bookingTableBody');
	/* Clear previous rows */
	tbody.innerHTML = ''; 
	
	bookings.forEach(b => {
		const tr = document.createElement('tr');
		tr.innerHTML = '
			<td>${b.booking_id}</td>
			<td>${b.guest_id}</td>
			<td>${b.room_id}</td>
			<td>${b.check_in}</td>
			<td>${b.check_out}</td>
			<td>${b.booking_status}</td>
			<td>${b.payment_status}</td>
			<td>${b.booking_source}</td>
			<td>
				<button onclick="editBooking(${b.booking_id})">Edit</button>
				<button onclick="deleteBooking(${b.booking_id})">Delete</button>
			</td>
		';
		tbody.appendChild(tr);
	});
}

/* update booking */
function updateBooking(bookingId, updateData) {
	fetch('${apiUrl}? id=${bookingId} ', {
		method: 'PUT',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify(data0
	})
	.then(response => response.json())
	.then(result => {
			console.log('Booking updated: ', result);
			alert("Booking updated successfully.");
			/* Refresh bookings List if needed */
			fetchBookings();
	})
	.catch(error => console.error('Error update booking: ', error));
}

/* Delete booking */
function deleteBooking(bookingId) {
	const confirmDelete = ("Are you sure you want to delete this booking?");
	if (!confirmDelete) return;
	
	fetch('${apiUrl}? id=${bookingId} ', {
		emthod: 'DELETE'
	})
	.then(response =>response.json())
	.then(result => {
		console.log('Booking deleted:', result);
		alert("Booking deleted successfully.");
		/* Refresh the bookings list */
		fetchBookings();
	})
	.catch(error => {
		console.error('Error deleting booking: ', error);
		alert("Failed to delete booking.");
	});
}


/* Initialize on page load */
window.onload = () => 
	fetchBookings();
};
