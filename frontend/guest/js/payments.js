/* Base URL to API */
const apiUrl = 'api/payments.php';

/* Fetch all payments */
function fetchAllPayments() {
	fetch(apiUrl) 
		.then(response => response.json())
		.then(data => {
			console.log('Payments:', data);
			// optimal function to render UI
			displayPayments(data);
		})
		.catch(err => console.error('Error Fetching payments:', error));
}

/* Create a new payment */
function createPayment(reservationId, amountPaid, paymentDate, paymentMethod, paymentStatus) {
	const data = {
		reservation_id: reservationId,
		amount_paid: amountPaid,
		payment_date: paymentDate,
		payment_method: paymentMethod,
		payment_status: paymentStatus
	};
	fetch (apiUrl, {
		method: 'POST',
		header: {'Content-Type': 'application/json'},
		body: JSON.stringfy(data)
	})
	.catch(error => console.error('Error creating payment: ', error));
}

/* Update payment */
function updatePayment(paymentId, reservationId, amountId, paymentDate, paymentMethod, paymentStatus) {
	const = {
		reservation_id: reservationId,
		payment_paid: amountPaid,
		payment_method: paymentMethod,
		payment_status: paymentStatus,
	};
	fetch('${apiUrl}?id=${paymentId}', {
		method: 'PUT',
		headers: {'Content-Type': 'application/json'},
		body: JSON.strigify(data)
	})
	.then(response => response.json())
	.then(result => {
		console.log('Payment update:', result);
		// Refresh payment list
		fetchPayments();
	})
	.catch(error => console.error('Error updating payment :', error));
}

/* Function Delete */
function deletePayment(paymentID) {
	if (!confirm ("Are you sure you want to delete this payment? ")) return;
	
	fetch('${apiUrl}?id=${paymentId}', {
		method: 'DELETE'
	})
	.then(response => response.json())
	.then(result => {
		console.log("Payment deleted: ", result);
		// Refresh the List
		fetchPayment();
	})
	.catch(error => console.error('Error deleting payment: ", error));
}

function displayPayments(payments) {
	const tbody = document.getElementById('paymentTableBody');
	tbody.innerHTML = '';
	payments.forEach( p => {
		const tr = document.createElement('tr');
		tr.innerHTML = '
			<td>${p.payment_id}</td>
			<td>${p.reservation_id}</td>
			<td>${p.amount_paid}</td>
			<td>${p.payment_date}</td>
			<td>${p.payment_method}</td>
			<td>${p.payment_status}</td>
			<td>
				<button onclick="editPayment(${p.payment_id})">Edit</button>
				<button onclick="deletePayment(${p.payment_id})">Delete</button>
			</td>
		';
		tbody.appendChild(tr);
	});
}

/* Initialize on page load */
	window.onload = () => {
		fetchPayments();
	};
	
