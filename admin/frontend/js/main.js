// Base URL for the API (Assuming your API is hosted locally or on a server)
const API_URL = 'http://localhost:3000/services/backend/api/guests'; // Adjust URL based on your API endpoint

// Fetch all guests
function getGuests() {
    fetch(API_URL)
        .then(response => response.json())
        .then(data => {
            console.log('Guests fetched:', data);
            displayGuests(data);  // Function to display guests on the frontend
        })
        .catch(error => console.error('Error fetching guests:', error));
}

// Add a new guest
function addGuest(guestData) {
    fetch(API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(guestData)  // Send the guest data as JSON
    })
        .then(response => response.json())
        .then(data => {
            console.log('New guest added:', data);
            getGuests();  // Reload the guests list
        })
        .catch(error => console.error('Error adding guest:', error));
}

// Update a guest's details
function updateGuest(guestId, updatedData) {
    fetch(`${API_URL}/${guestId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedData)
    })
        .then(response => response.json())
        .then(data => {
            console.log('Guest updated:', data);
            getGuests();  // Reload the guests list
        })
        .catch(error => console.error('Error updating guest:', error));
}

// Delete a guest
function deleteGuest(guestId) {
    fetch(`${API_URL}/${guestId}`, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => {
            console.log('Guest deleted:', data);
            getGuests();  // Reload the guests list
        })
        .catch(error => console.error('Error deleting guest:', error));
}

// Function to display guests on the page (example)
function displayGuests(guests) {
    const guestList = document.getElementById('guest-list');
    guestList.innerHTML = '';  // Clear the list

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

// Function to populate the edit form with a guest's details (for editing)
function populateEditForm(guestId) {
    fetch(`${API_URL}/${guestId}`)
        .then(response => response.json())
        .then(data => {
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
        })
        .catch(error => console.error('Error fetching guest for edit:', error));
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

    addGuest(guestData);  // Call the function to add a new guest
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

    updateGuest(guestId, updatedData);  // Call the function to update guest data
});

// Initial load: Fetch all guests when the page is loaded
document.addEventListener('DOMContentLoaded', getGuests);

// main.js: Handles API requests for the "rooms" CRUD operations using AJAX

// Base URL of the API (make sure to adjust it to the actual URL where your backend is hosted)
const apiUrl = 'http://localhost/api/rooms';

// Function to make GET requests
function makeGetRequest(url, callback) {
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => callback(data))
    .catch(error => console.error('Error:', error));
}

// Function to make POST requests (Create a new room)
function makePostRequest(url, data, callback) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => callback(data))
    .catch(error => console.error('Error:', error));
}

// Function to make PUT requests (Update an existing room)
function makePutRequest(url, data, callback) {
    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => callback(data))
    .catch(error => console.error('Error:', error));
}

// Function to make DELETE requests (Delete a room)
function makeDeleteRequest(url, callback) {
    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => callback(data))
    .catch(error => console.error('Error:', error));
}

// Example: Fetch and display all rooms
function fetchRooms() {
    makeGetRequest(apiUrl, function(rooms) {
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
    });
}

// Example: Create a new room
function createRoom() {
    const roomData = {
        room_number: document.getElementById('room_number').value,
        room_type: document.getElementById('room_type').value,
        floor_number: document.getElementById('floor_number').value,
        price_per_night: parseFloat(document.getElementById('price_per_night').value),
        room_status: document.getElementById('room_status').value,
        room_description: document.getElementById('room_description').value,
        beds_count: parseInt(document.getElementById('beds_count').value),
        capacity: parseInt(document.getElementById('capacity').value)
    };

    makePostRequest(apiUrl, roomData, function(response) {
        alert(response.message);
        fetchRooms(); // Refresh room list after creation
    });
}

// Example: Edit an existing room
function editRoom(roomId) {
    // Get room data for the specified room_id
    makeGetRequest(`${apiUrl}/get_room.php?room_id=${roomId}`, function(room) {
        if (room) {
            // Populate form fields with existing room data
            document.getElementById('room_id').value = room.room_id;
            document.getElementById('room_number').value = room.room_number;
            document.getElementById('room_type').value = room.room_type;
            document.getElementById('floor_number').value = room.floor_number;
            document.getElementById('price_per_night').value = room.price_per_night;
            document.getElementById('room_status').value = room.room_status;
            document.getElementById('room_description').value = room.room_description;
            document.getElementById('beds_count').value = room.beds_count;
            document.getElementById('capacity').value = room.capacity;
        }
    });
}

// Function to update room details
function updateRoom() {
    const roomData = {
        room_id: document.getElementById('room_id').value,
        room_number: document.getElementById('room_number').value,
        room_type: document.getElementById('room_type').value,
        floor_number: document.getElementById('floor_number').value,
        price_per_night: parseFloat(document.getElementById('price_per_night').value),
        room_status: document.getElementById('room_status').value,
        room_description: document.getElementById('room_description').value,
        beds_count: parseInt(document.getElementById('beds_count').value),
        capacity: parseInt(document.getElementById('capacity').value)
    };

    makePutRequest(`${apiUrl}/update_room.php`, roomData, function(response) {
        alert(response.message);
        fetchRooms(); // Refresh room list after update
    });
}

// Function to delete a room
function deleteRoom(roomId) {
    if (confirm('Are you sure you want to delete this room?')) {
        makeDeleteRequest(`${apiUrl}/delete_room.php?room_id=${roomId}`, function(response) {
            alert(response.message);
            fetchRooms(); // Refresh room list after deletion
        });
    }
}

// On page load, fetch the list of rooms
document.addEventListener('DOMContentLoaded', function() {
    fetchRooms();
});

// Event listener for creating a room (from a form)
document.getElementById('create-room-form').addEventListener('submit', function(event) {
    event.preventDefault();
    createRoom();
});

// Event listener for updating a room (from a form)
document.getElementById('update-room-form').addEventListener('submit', function(event) {
    event.preventDefault();
    updateRoom();
});

