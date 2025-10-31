// Frontend/js/views/roomPage.js 

export const renderRoomTable = (rooms) => {
    const tableBody = document.getElementById("room-table-body");
    if (!tableBody) return;
    tableBody.innerHTML = "";

    rooms.forEach((room) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                <td>${room.room_number}</td>
                <td>${room.room_type_name}</td>
                <td>${room.floor_number}</td>
                <td>${room.beds_count}</td>
                <td>${room.capacity}</td>
                <td>${room.price_per_night.toFixed(2)}</td>
                <td>${room.room_status}</td>
                <td>${room.room_description || ""}</td>
                <td>
                    <button onclick="editRoomUI(${room.room_id})">Edit</button>
                    <button onclick="deleteRoomUI(${room.room_id})">Delete</button>
                </td>
            `;
        tableBody.appendChild(row)    ;
    });
};

export const populateRoomForm = (room) => {
    document.getElementById("room-id").value = room.room_id;
    document.getElementById("room-number").value = room.room_number;
    document.getElementById("room-type-id").value = room.room_type_id;
    document.getElementById("floor-number").value = room.floor_number;
    document.getElementById("beds-count").value = room.beds_count;
    document.getElementById("capacity").value = room.capacity;
    document.getElementById("price-per-night").value = room.price_per_night;
    document.getElementById("room-status").value = room.room_status;
    document.getElementById("room-description").value = room.room_description;
};

export const clearRoomForm = () => {
    document.getElementById("room-id").value = "";
    document.getElementById("room-number").value = "";
    document.getElementById("room-type-id").value = "";
    document.getElementById("floor-number").value = 0;
    document.getElementById("beds-count").value = 1;
    document.getElementById("capacity").value = 1;
    document.getElementById("price-per-night").value = 0.0;
    document.getElementById("room-status").value = "Available";
    document.getElementById("room-description").value = "";
}

