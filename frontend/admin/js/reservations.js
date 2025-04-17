/* Base URL to  API  */
const apiUrl = 'api/reservations.php';

/* Fetch all reservations  */
function fetchReservations() {
	fetch(apiUrl) 
		.then(response => response.json())
		.then(data => {
			console.log('reservations:', data);
			displayReservations(data);
		});
		.catch(error => console.error("Error fetching reservations: ', error));
	}
	
	/* Create a new reservation */
	function createReservation(guestId, roomId, checkIn, checkOut, reservationsStatus, paymentStatus) {
		const data = {
				quest_id: guestId,
				room_id: roomId,
				check_in: checkIn,
				check_out: checkOut,
				reservation_status: reservationStatus,
				payment_status: paymentStatus
		};
		
		fetch(apiUrl, {
				method: 'POST',
				headers: { 'Content-type': 'application/json' },
				body: JSON.stringify(data)
		})
		.then(response => response.json()) 
		.tnen(result => {
				console.log("Reservation created ', result);
				fetchReservations(); // Refresh List 
		})
		.catch(error => console.error('Error creating reservations:', error));
	}
	
	/* Update reservation status and/or payment  */
	function updateReservation(reservarations, status, payment) {
		const = {
				reservation_status: status,
				payment_status: payment 
		};
		fetch('${apiUrl}? id=${reservationId}', {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(data)
		})
		.then(response => response.json()) 
		.then(result => {
				console.log('Reservation updated: ', result);
				fetchReservations();
		})
		.catch(error => console.error('Error updating reservation: ', error));
	}
	
	/* Delete(cancel) a reservations */
	function deleteReservation(reservationId) {
			if (!confirm('Concel this reservation?')) return;
			
			fetch('${apiUrl}?Id=${reservationId}', {
				method : 'DELETE'
			})
			.then(response => resonse.json())
			.then(result => {
				console.log('Reservation cancelled: ', result);
				fetchReservations();
			})
			.catch(error => console.error('Error deleting reservation: ', error));
	}
	
	/* Display reservations in a table */
	function displayrReservations(reservations) {
		const tbody = document.getElementById('reservationTableBody');
		tbody.innerHTML = '';
		
		reservations.forEarch( r => {
			const tr = document.createElement('tr');
			tr.innerHTML = '
				<td>${r.reservation_id}</td>
				<td>${r.guest_id}</td>
				<td>${r.room_id}</td>
				<td>${r.check.in}</td>
				<td>${r.check_out}</td>
				<td>${r.reservation_status}</td>
				<td>${r.payment_status}</td>
				<td>
					<button onclick="editReservartion(${r.reservation_id})">Edit</button>
					<button onclick="deleteReservation(${r.reservation_id})">Cancel</button>
				</td>
				';
				tbody.appendChild(tr);
		});
	}
	
	 /* Prompt UI for creating new reservation */
	 function addNewReservation() {
		 const guestId = prompt("Guest ID: ");
		 const roomId = prompt("Room ID: ");
		 const checkIn = prompt("Check-in date(YYYY-MM-DD): ");
		 const checkOut = prompt("Check-out date(YYYY-MM-DD): ");
		 const reservationStatus = prompt("Reservation Status (Pending/Confirmed/Cancelled): ", "Pending");
		 const paymentStatus = prompt("Payment Status (paid/Pending): ", "Pending");
		 
		 if (guestId && roomId && checkIn, checkOut, reservationStatus, paymentStatus)
			   createReservation(guestId, roomId), checkIn, checkOut, reservaationStatus, paymentStatus);
		}
	}
	
	/* Prompt Ui for editing reservation 	*/
	function editReservation(reservationId) {
		const status =  prompt("New Reservation Status (Pending/Confirmed/Cancelled): ");
		const payment = prompt("New Payment Status (Paid/Pending): ");
		
		if (status && payment) {
			updateReservation(reservationId, status, payment);
		}
	}
	
	/* Initialize on page load */
	window.onload = () => {
		fetchReservations();
	};
	
		
	
				
