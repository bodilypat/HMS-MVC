// Base URL for the API (Adjust to the actual API endpoint)
const API_URL = 'http://localhost:3000/services/backend/api/guests'; // Change to your actual URL

// Function to make API requests (GET, POST, PUT, DELETE)
async function makeApiRequest(url, method, data = null) {
    const options = {
        method,
        headers: { 'Content-Type': 'application/json' }
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(url, options);
        const result = await response.json();
        return result;
    } catch (error) {
        console.error(`Error with ${method} request to ${url}:`, error);
        throw error; // Rethrow for further handling if needed
    }
}

// Fetch all guests
async function getGuests() {
    try {
        const data = await makeApiRequest(API_URL, 'GET');
        console.log('Guests fetched:', data);
        displayGuests(data); // Function to display guests on the frontend
    } catch (error) {
        console.error('Error fetching guests:', error);
    }
}

// Add a new guest
async function addGuest(guestData) {
    try {
        const data = await makeApiRequest(API_URL, 'POST', guestData);
        console.log('New guest added:', data);
        getGuests(); // Reload the guests list
    } catch (error) {
        console.error('Error adding guest:', error);
    }
}

// Update a guest's details
async function updateGuest(guestId, updatedData) {
    try {
        const data = await makeApiRequest(`${API_URL}/${guestId}`, 'PUT', updatedData);
        console.log('Guest updated:', data);
        getGuests(); // Reload the guests list
    } catch (error) {
        console.error('Error updating guest:', error);
    }
}

// Delete a guest
async function deleteGuest(guestId) {
    try {
        const data = await makeApiRequest(`${API_URL}/${guestId}`, 'DELETE');
        console.log('Guest deleted:', data);
        getGuests(); // Reload the guests list
    } catch (error) {
        console.error('Error deleting guest:', error);
    }
}

// Function to display guests on the page
function displayGuests(guests) {
    const guestList = document.getElementById('guest-list');
    guestList.innerHTML = ''; // Clear the list

    guests.forEach(guest => {
        const guestItem = document.createElement('div');
        guestItem.classList.add('guest-item');
        guestItem.innerHTML = `
            <p>Name: ${guest.first_name} ${guest.last_name}</p>
            <p>Email: ${guest.email}</p>
            <p>Phone: ${guest.phone_number}</p>
            <button onclick="deleteGuest(${guest.guest_id})">Delete</button>
            <button onclick="populateEditForm(${guest.guest_id})">Edit</button>
        `;
        guestList.appendChild(guestItem);
    });
}

// Function to populate the edit form with a guest's details
async function populateEditForm(guestId) {
    try {
        const data = await makeApiRequest(`${API_URL}/${guestId}`, 'GET');
        document.getElementById('edit-guest-id').value = data.guest_id;
        document.getElementById('edit-first-name').value = data.first_name;
        document.getElementById('edit-last-name').value = data.last_name;
        document.getElementById('edit-email').value = data.email;
        document.getElementById('edit-phone').value = data.phone_number;
        document.getElementById('edit-address').value = data.address;
        document.getElementById('edit-id-type').value = data.id_type;
        document.getElementById('edit-id-number').value = data.id_number;
        document.getElementById('edit-dob').value = data.dob;
        document.getElementById('edit-nationality').value = data.nationality;
        document.getElementById('edit-check-in-date').value = data.check_in_date;
        document.getElementById('edit-check-out-date').value = data.check_out_date;
    } catch (error) {
        console.error('Error fetching guest for edit:', error);
    }
}

// Event listener for the "Add Guest" form
document.getElementById('add-guest-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const guestData = {
        first_name: document.getElementById('first-name').value,
        last_name: document.getElementById('last-name').value,
        email: document.getElementById('email').value,
        phone_number: document.getElementById('phone').value,
        address: document.getElementById('address').value,
        id_type: document.getElementById('id-type').value,
        id_number: document.getElementById('id-number').value,
        dob: document.getElementById('dob').value,
        nationality: document.getElementById('nationality').value,
        check_in_date: document.getElementById('check-in-date').value,
        check_out_date: document.getElementById('check-out-date').value
    };
    addGuest(guestData); // Add a new guest
});

// Event listener for the "Edit Guest" form
document.getElementById('edit-guest-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const guestId = document.getElementById('edit-guest-id').value;
    const updatedData = {
        first_name: document.getElementById('edit-first-name').value,
        last_name: document.getElementById('edit-last-name').value,
        email: document.getElementById('edit-email').value,
        phone_number: document.getElementById('edit-phone').value,
        address: document.getElementById('edit-address').value,
        id_type: document.getElementById('edit-id-type').value,
        id_number: document.getElementById('edit-id-number').value,
        dob: document.getElementById('edit-dob').value,
        nationality: document.getElementById('edit-nationality').value,
        check_in_date: document.getElementById('edit-check-in-date').value,
        check_out_date: document.getElementById('edit-check-out-date').value
    };
    updateGuest(guestId, updatedData); // Update the guest details
});

// Initial load: Fetch all guests when the page is loaded
document.addEventListener('DOMContentLoaded', getGuests);


// Base URL of the API
const apiUrl = 'http://localhost/services/backend/api/rooms';

// Helper function to handle all API requests (GET, POST, PUT, DELETE)
async function apiRequest(url, method = 'GET', data = null) {
    const options = {
        method,
        headers: {
            'Content-Type': 'application/json',
        },
    };
    if (data) {
        options.body = JSON.stringify(data); // Add body data for POST/PUT requests
    }

    try {
        const response = await fetch(url, options);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error(`Error ${method} ${url}:`, error);
        alert('Something went wrong. Please try again later.');
    }
}

// Fetch and display all rooms
async function fetchRooms() {
    const rooms = await apiRequest(apiUrl);
    const roomsList = document.getElementById('rooms-list');
    roomsList.innerHTML = ''; // Clear the list first
    rooms.forEach(room => {
        const roomItem = document.createElement('div');
        roomItem.classList.add('room-item');
        roomItem.innerHTML = `
            <p>Room Number: ${room.room_number}</p>
            <p>Type: ${room.room_type}</p>
            <p>Floor: ${room.floor_number}</p>
            <p>Price per Night: $${room.price_per_night}</p>
            <p>Status: ${room.room_status}</p>
            <p>Description: ${room.room_description}</p>
            <button onclick="editRoom(${room.room_id})">Edit</button>
            <button onclick="deleteRoom(${room.room_id})">Delete</button>
        `;
        roomsList.appendChild(roomItem);
    });
}

// Create a new room
async function createRoom() {
    const roomData = getRoomFormData('create');
    const response = await apiRequest(apiUrl, 'POST', roomData);
    alert(response.message);
    fetchRooms(); // Refresh room list after creation
}

// Edit an existing room
async function editRoom(roomId) {
    const room = await apiRequest(`${apiUrl}/get_room.php?room_id=${roomId}`);
    if (room) {
        populateRoomForm('edit', room);
    }
}

// Populate the room form (create or edit)
function populateRoomForm(type, room) {
    const prefix = type === 'create' ? '' : 'edit-';
    document.getElementById(`${prefix}room_id`).value = room.room_id || '';
    document.getElementById(`${prefix}room_number`).value = room.room_number || '';
    document.getElementById(`${prefix}room_type`).value = room.room_type || '';
    document.getElementById(`${prefix}floor_number`).value = room.floor_number || '';
    document.getElementById(`${prefix}price_per_night`).value = room.price_per_night || '';
    document.getElementById(`${prefix}room_status`).value = room.room_status || '';
    document.getElementById(`${prefix}room_description`).value = room.room_description || '';
    document.getElementById(`${prefix}beds_count`).value = room.beds_count || '';
    document.getElementById(`${prefix}capacity`).value = room.capacity || '';
}

// Get room form data
function getRoomFormData(type) {
    const prefix = type === 'create' ? '' : 'edit-';
    return {
        room_id: document.getElementById(`${prefix}room_id`).value,
        room_number: document.getElementById(`${prefix}room_number`).value,
        room_type: document.getElementById(`${prefix}room_type`).value,
        floor_number: document.getElementById(`${prefix}floor_number`).value,
        price_per_night: parseFloat(document.getElementById(`${prefix}price_per_night`).value),
        room_status: document.getElementById(`${prefix}room_status`).value,
        room_description: document.getElementById(`${prefix}room_description`).value,
        beds_count: parseInt(document.getElementById(`${prefix}beds_count`).value),
        capacity: parseInt(document.getElementById(`${prefix}capacity`).value),
    };
}

// Update room details
async function updateRoom() {
    const roomData = getRoomFormData('edit');
    const response = await apiRequest(`${apiUrl}/update_room.php`, 'PUT', roomData);
    alert(response.message);
    fetchRooms(); // Refresh room list after update
}

// Delete a room
async function deleteRoom(roomId) {
    if (confirm('Are you sure you want to delete this room?')) {
        const response = await apiRequest(`${apiUrl}/delete_room.php?room_id=${roomId}`, 'DELETE');
        alert(response.message);
        fetchRooms(); // Refresh room list after deletion
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', fetchRooms);

document.getElementById('create-room-form').addEventListener('submit', function (event) {
    event.preventDefault();
    createRoom();
});

document.getElementById('update-room-form').addEventListener('submit', function (event) {
    event.preventDefault();
    updateRoom();
});

// URL of your API
const apiUrl = 'http://localhost/services/api/room_services.php';

// Function to get all room service records
function getRoomServices() {
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);  // Handle case where no records are found
            } else {
                displayRoomServices(data);  // Function to display data
            }
        })
        .catch(error => console.error('Error fetching room services:', error));
}

// Function to get a single room service record by ID
function getRoomServiceById(id) {
    fetch(`${apiUrl}?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);  // Handle case where record is not found
            } else {
                displayRoomService(data);  // Function to display a single record
            }
        })
        .catch(error => console.error('Error fetching room service:', error));
}

// Function to create a new room service record
function createRoomService() {
    const serviceData = {
        reservation_id: document.getElementById('reservation_id').value,
        service_type: document.getElementById('service_type').value,
        service_request_time: document.getElementById('service_request_time').value,
        service_status: document.getElementById('service_status').value,
    };

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(serviceData),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);  // Show success or failure message
        if (data.room_service_id) {
            console.log('Room Service ID:', data.room_service_id);  // Log the created record ID
        }
    })
    .catch(error => console.error('Error creating room service:', error));
}

// Function to update an existing room service record
function updateRoomService(id) {
    const serviceData = {
        reservation_id: document.getElementById('reservation_id').value,
        service_type: document.getElementById('service_type').value,
        service_request_time: document.getElementById('service_request_time').value,
        service_status: document.getElementById('service_status').value,
    };

    fetch(`${apiUrl}?id=${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(serviceData),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);  // Show success or failure message
    })
    .catch(error => console.error('Error updating room service:', error));
}

// Function to delete a room service record
function deleteRoomService(id) {
    if (confirm('Are you sure you want to delete this room service record?')) {
        fetch(`${apiUrl}?id=${id}`, {
            method: 'DELETE',
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);  // Show success or failure message
        })
        .catch(error => console.error('Error deleting room service:', error));
    }
}

// Function to display all room services
function displayRoomServices(services) {
    const tableBody = document.getElementById('room_services_table_body');
    tableBody.innerHTML = ''; // Clear existing data

    services.forEach(service => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${service.room_service_id}</td>
            <td>${service.reservation_id}</td>
            <td>${service.service_type}</td>
            <td>${service.service_request_time}</td>
            <td>${service.service_status}</td>
            <td>
                <button onclick="getRoomServiceById(${service.room_service_id})">View</button>
                <button onclick="updateRoomService(${service.room_service_id})">Edit</button>
                <button onclick="deleteRoomService(${service.room_service_id})">Delete</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
}

// Function to display a single room service
function displayRoomService(service) {
    document.getElementById('reservation_id').value = service.reservation_id;
    document.getElementById('service_type').value = service.service_type;
    document.getElementById('service_request_time').value = service.service_request_time;
    document.getElementById('service_status').value = service.service_status;
}

// Event listeners for adding, updating, and deleting room services
document.getElementById('create_room_service_btn').addEventListener('click', createRoomService);

// Fetch all room services when the page loads
window.onload = function() {
    getRoomServices();
};

