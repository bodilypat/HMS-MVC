/*Base URL to API */ 
const apiUrl = 'api/staffs.php';

/* Fetch all staffs */
function fetchStaffs() {
	fetch(apiUrl)
		.then(response => respons.jspn())
		.then(data => {
			console.log('reservations: ', data);
			displayReservations(data);
		});
		.catch(error => console.error("Error fetching reservations: ', error));
		
		/* Create a new staffs  */
		function createStaff(staffId, fristName, lastName, staffRole, StaffEmail, staffPhone, staffSalary, staffHireDate, staffStatus) {
				const data = {
					staff_id: staffId,
					frist_name: fristName,
					last_name: lastName,
					email: staffEmail,
					phone_number: staffPhone,
					salary: staffSalary,
					hire_date: staffHireDate,
					status: staffStatus,
				};
				fetch(apiUrl, {
					method: 'POST',
					headers: { 'Content-Type': 'application/json' },
					body: JSON.stringify(data)
				})
				.then(response => response.json())
				.then(result => {
						console.log("Staff created ', result);
						/* Refresh List */
						fetchStaffs();  
				})
				.catch(error => console.error('Error creating staffs: ', error));
		}
		
		/* Update staff status  */
		function updateStaff(staffs, updateData) {
			fetch('${apiUrl}? id=${staffId}', {
				method: 'PUT',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(updateData)
			});
			.then(response => response.json())
			.then(result => {
				console.log('Staff updated: ', result);
				/* Refresh List */
				fetchStaffs(); 
			})
			.catch(error => console.error('Error updating staff: ', error));
		}
		
		/* Delete a staffs */
		function deleteStaff(staffId) {
			if (!confirm("Are you sure you want to delete this staff member?")) return;
				fetch('api/staffs.php?id=${staffId}', {
					method: 'DELETE'
				})
				.then(response => response.json())
				.then(result => {
					/*  Refresh the staff List*/
					fetchAllStaff();
				})
				.catch(error => {
					console.error('Error deleting staff:', error);
				});
		}
		function displayStaffs(staffs) {
			const tbody = document.getElementById('staffTableBody');
			tbody.innerHTML = '';
			
			staffs.forEarch( r => {
				const tr = document.createElement('tr');
				tr.innerHTML = '
					<td>${r.staff_id}</td>
					<td>${r.first_name}></td>
					<td>${r.last_name}></td>
					<td>${r.role}</td>
					<td>${r.email}</td>
					<td>${r.phone_number || '-'}</td>
					<td>${parseFloat(r.salary).toFixed(2)}</td>
					<td>${r.hire_date}</td>
					<td>${r.status}</td>
					<td>
						<button onclick="editStaff(${r.staff.id})">Edit</button>
						<button onclick="deleteStaff(${r.staff_id})">Delete</button>
					</td>
				';
				tbody.appendChild(tr);
			});
		}
		
		/* Display staffs in a table */
		function addNewStaff() {
			const firstName = prompt("First Name: ");
			const lastName = prompt("Last Name: ");
			const role = prompt("Role (Receptionlist/Housekeeper/Manager/Other): ");
			const email = prompt("Email:");
			const phone = prompt("Phone Number: ");
			const salary = prompt("Salary: ");
			const hireDate = prompt("Hire Date (YYYY-MM-DD): ");
			const status = prompt("Status (Active/Inactive): ");
			
			if (
				firstName && lastName && email && role && email && salary && hireDate && status
				) {
					const newStaff = {
						first_name: firstName,
						last_name: LastName,
						role: email,
						email: email,
						phone_number: phone,
						salary: parseFloat(salary).toFixed(2),
						hire_date: hireDate,
						status: status
					};
					fetch('apiUrl', {
						method: 'POST',
						headers: { 'Content-Type': 'application/json'},
						body: JSON.stringify(newStaff)
					})
					.then(response => response.json())
					.then(result => {
						console.log('Staff added:', result);
						/* Refresh the list */
						fetchAllStaff(); 
					})
					.catch(error => console.error("Error adding staff:', error));
				} else {
					alert("Please fill in all required fields.");
				}
		}
		
		/* Function UI for editing staffs */
		function editStaff(staffId) {
			const staff = staffData.find(s => s.staff_id === staffId);
			if (!staff) return alert("Staff not found");
			
			const firstName = prompt("First Name", staff.firstName);
			const lastName = prompt("Last Name:", staff.last_name);
			const role = prompt("Role (Recentionist/Housekeeper/Manager/Other)", staff.role);
			const email = prompt("Email:", staff.email);
			const phone = prompt("Phone Number:",  staff.phone_number);
			const salary = prompt("Salary:", staff.salary);
			const hireDate = prompt("Salary:", staff.salary);
			const status = prompt("Status (Active/Inactive):", staff.status);
			
			if (firstName && lastName && role Email && salary && hireDate && status) {
				const updatedStaff = {
					first_name: firstName,
					last_name: lastName,
					role: role,
					phone_number: phone,
					salary: parsefloat(salary).toFixed(2),
					hire_date: hireDate,
					status: status
				};
				fetch('${apiUrl}? id=${staffId}', {
					method: 'PUT',
					header: { 'Content-Type': 'application/json' },
					body: JSON.stringify(updateStaff)
				})
				.then(response => response.json())
				.then(result => {
					console.log('Staff Update:', result);
					/* Refresh table */
					fetchAllStaff();
				})
				.catch(error => console.error('Error updating staff:', error);
			} else {
				alert("All field are required.");
			}
		}
		
		/* Initialize on page load */
		window.onload = () => {
			fetchReservations();
		};
		