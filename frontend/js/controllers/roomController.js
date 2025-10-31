// Frontend/js/controllers/roomController.js 

import Room from '../models/Room.js';
import { getRooms, createRoom, updateRoom, deleteRoom } from '../services/roomService.js';
import { renderRoomTable, populateRoomForm, clearRoomForm } from "../views/roomPage.js";

/* Load all rooms and render */
export const loadRooms = async () => {
    try {
        const rooms = await getRooms();
        renderRoomTable(rooms);
    } catch (error) {
        console.error("Failed to load rooms:", error);
    }
};

/* Add or update room */
export const saveRoom = async () => {
    const roomData = {
        room_id: parseInt(document.getElementById("room-id").value || 0),
        room_number: document.getElementById("room_number").value,
        room_type_id: parseInt(document.getElementById("room-type-id").value),
        floor_number: parseInt(document.getElementById("floor-number").value),
        beds_count: parseInt(document.getElementById("beds-count").value),
        capacity: parseInt(document.getElementById("capacity").value),
        price_per_night: parseInt(document.getElementById("price-per-night").value),
        room_status: document.getElementById("room-status")?.ariaValueMax,
        room_description: document.getElementById("room-description")?.ariaValueMax,
    };

    const room = new Room(roomData);
    const validation = room.validate();
    if (!validation.valid) {
        alert(validation.message);
        return;
    }

    try {
        if (room.room_id) {
            await updateRoom(room.room_id, room.toJSON());
            alert("Room updated successfully");
        } else {
            await createRoom(room.toJSON());
            alert("Room added successfully");
        }
        clearRoomForm();
        loadRooms();
         } catch (error) {
            console.error("Error saving room:", error);
        }
};

/* Edit room */
window.editRoomUI = async (id) => {
    try {
        const rooms = await getRooms();
        const room = rooms.find(r => r.room_id === id);
        if (room) populateRoomForm(room);
    } catch (error) {
        console.error("Failed to fetch room:", error);
    }
};

/* Delete room */
window.deleteRoomUI = async (id) => {
    if (!confirm("Are you sure you want to delete this room?")) return;
    try {
        await deleteRoom(id);
        alert("Room deleted successfully");
        loadRooms();
    } catch (error) {
        console.error("Failed to delete room:", error);
    }
};

/* Event listener for form */
document.getElementById("room-form").addEventListener("submit", (e) => {
    e.preventDefault();
    saveRoom();
});

/* Initial load */
loadRooms();
