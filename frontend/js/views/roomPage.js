// frontend/js/views/roomPage.js 

import * as roomController from '../controllers/roomController.js';

/* DOM Elements */
const tableBody = document.querySelector('#room-table-body');
const roomPage = document.querySelector('#roomForm');

/* Initialze page */
document.addEventListener('DOMContentLoaded', () => {
    roomController.loadRooms();
});

/* Render room table */
export function renderRoomTable(rooms = []) {
    if (!tableBody) return;

    tableBody.innerHTML = '';

    if (rooms.length === 0) {
        tableBody.innerHTML= `
            <tr><td colspan="9" class="no-data">No rooms available.</td></tr>
        `;
        return;
    }

    rooms.forEach(room => {
        const row = document.createElement('tr');
        row.dataset.id = room.room_id;
        row.innerHTML = `
            <td>${room.room_number}</td>
            <td>${room.room_type_name}</td>
            <td>${room.floor_number}</td>
            <td>${room.beds_count}</td>
            <td>${room.capacity}</td>
            <td>${Number(room.price_per_night).toFixed(2)}</td>
            <td>${room.room_status}</td>
            <td>${room.room_description || '-'}</td>
            <td>
                <button class="btn-edit" data-id="${room.room_id}">Edit</button>
                <button class="btn-delete" data-id="${room.room_id}>Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    /* Attach event listname */
    tableBody.querySelectorAll('.btn-edit').forEach(btn => 
        btn.addEventListener('click', e=> {
            const id = e.target.dataset.id;
            roomController.editRoom(id);
        })
    );

    tableBody.querySelectorAll('.btn-delete').forEach(btn => 
        btn.addEventListener('click', e => {
            const id = e.target.dataset.id;
            if (confirm('Delete this room?')) roomController.removeRoom(id);
        })
    );
}

/* Populate the room from (for editing) */
export function populateRoomForm(room) {
    if (!roomForm) return;
    
    roomForm.room_id.value = room.room_id;
    roomForm.room_number.value = room.room_number;
    roomForm.room_type_id.value = room.room_type_id;
    roomForm.floor_number.value = room.floor_number;
    roomForm.beds_count.value = room.beds_count;
    roomForm.capacity.value = room.capacity;
    roomForm.price_per_night.value = room.price_per_night;
    roomForm.room_status.value = room.room_status,
    roomForm.room_description.value = room.room_description || '';
}

/* Clear the room form */
export function clearRoomForm() {
    if (!roomForm) return;
        roomForm.reset();

        roomForm.room_id.value = '';
        roomForm.room_status.value = 'Available';
        roomForm.floor_number.value = 1;
        roomForm.beds_count.value = 1;
        roomForm.capacity.value = 1;
        roomForm.price_per_night.value = 0;
}

/* Show error feedback */
export function showError(message) {
    alert(message);
}

/* Show success feedback */
export function showSuccess(message) {
    alert(message);
}

