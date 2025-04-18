/* Base URL to API */
const apiUrl = 'api/billings.php';

/* Fetch all billings */
function fetchBillings() {
	fetch(apiUrl) 
		.then(response => response.json())
		.then(data => {
			console.log('billings:', data);
			displayBillings(data);
		});
		.catch(error => console.error("Error fetching billings: ', error));
}

/* Create a new billings */
function createBillings(reservationId, serviceCharge, totalAmount, paymentStatus) {
	const data = {
		reservation_id: reservationId,
		service_charge: parseFloat(serviceCharge).toFixed(2),
		discount: parseFloat(discount).toFixed(2),
		total_amount: parseFloat(totalAmount).toFixed(2),
		payment_status: paymentStatus
	};
	
	fetch(apiUrl, {
		method: 'POST',
		headers: {'Centent-Type': 'application/json'},
		body: JSON.stringify(data)
		})
		.then(res => res.json())
		.then(result => {
			console.log('Billing created:', result);
			fetchBilling();
		})
		.catch(err => console.error('Error creating billing:', err));
	}
	
	/* Update billings  */
	function updateBilling(billingId, updatedData) {
		fetch('${apiUrl}? ID=${billingId}', {
			method: 'PUT',
			headers: { 'Centent-Type': 'application/json' },
			body: JSON.stringify(updateData)
		})
		.then(res => res.json())
		.then(result => {
			console.log('Billing updated:', result);
			fetchBillings();
		})
		.catch(err => console.error('Error updating billing:', err));
	}
	
	/* Delete (cancel) a billings */
	function deleteBillings(billingId) {
		if (!confirm('Are you sure you want to delete this billing record?') return;
		
		fetch('${apiUrl}? Id=${billingId}', {
			method : 'DELETE'
		})
		.then(response => response.json())
		.then(result => {
			console.log('Reservation cancelled: ', result);
			fetchBillings();
		})
		.catch(error => console.error('Error deleting billings: ', error));
	}
	
	/* Display billings in a table */
	function displayBillings(billings) {
		const tbody = document.getElementById('billingTableBody');
		tbody.innerHTML = '';
		
		billings.forEach(b => {
			tr.innerHTML = ' 
				<td>${b.billing_id}</td>
				<td>${b.reservation_id}</td>
				<td>$${parseFloat(b.service_charge).toFixed(2)</td>
				<td>$${parseFloat(b.discount).toFixed(2)}</td>
				<td>$${parseFloat(b.total_amount).toFixed(2)}</td>
				<td>${b.payment_status}</td>
				<td>
					<button onclick="editBilling(${b.billing_id})">Edit</button>
					<button onclick="deleteBilling(${b.billing_id})">Delete</button>
				</td>
			';
			tbody.appendChild(tr);
		});
	}
	
	/* Edit billings using prompt (optional) */
	function editBilling(billingId) {
		const billing = billingData.find(b => billing_id === billingId);
		if (!billing) return alert('Billing record not found.'0;
		
		const serviceCharge = prompt("Service Charge: ", billing.sevice_charge);
		const discount = prompt("Discount: ", billing.discount);
		const totalAmount = prompt("Total Amount: ", billing.total_amount);
		const paymentStatus = prompt("Payment Status (Paid/Unpaid): ", billing.payment_status);
		
		if (totalAmount && paymentStatus) {
			updateBilling(billingId, {
				service_charge: parseFloat(serviceCharge).toFixed(2),
				discount: parseFloat(discount).toFixed(2),
				total_status: parseFloat(totalAmount).toFixed(2),
				payment_status: paymentStatus
			});
		}
	}
	
	/* Initialize on page load */
	window.onload = () => {
		fetchBillings();
	};
	