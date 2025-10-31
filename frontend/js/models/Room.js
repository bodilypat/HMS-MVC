// Frontend/js/models/Room.js 

export default class Room {
    constructor({
        room_id = null,
        room_number = "",
        room_type_id = null,
        floor_number = 0,
        price_per_night = 0.0,
        room_status = "Available",
        room_description = "",
        beds_count = 1,
        capacity =1,
    } = {}) {
        this.room_id = room_id;
        this.room_number = room_number;
        this.room_type_id = room_type_id;
        this.floor_number = floor_number;
        this.price_per_night = price_per_night;
        this.room_status = room_status;
        this.room_description = room_description;
        this.beds_count = beds_count;
        this.capacity = capacity;
    }

    validate() {
        if (!this.room_number) return { valid: false, message: "Room number is required" };
        if (!this.room_type_id) return { valid: false, message: "Room type is required" };
        if (this.floor_number < 0) return { valid: false, message: "Floor number cannot be negative" };
        if (this.price_per_night < 0) return { valid: false, message: "Price per night cannot be negative" };
        if (this.beds_count <= 0) return { valid: false, message: "Beds count must be at least 1" };
        if (this.capacity < this.beds_count) return { valid: false, message: "Capacity cannot be less than beds count" };
        if (!["Available", "Occupied", "Maintenance"]. includes(this.room_status)) {
            return { valid:false, message: "Invalid room status" };
        }
        return { valid: true};
    }

    toJSON() {
        return {
            room_number: this.room_number,
            room_type_id: this.room_type_id,
            floor_number: this.floor_number,
            price_per_night: this.price_per_night,
            room_status: this.room_status,
            room_description: this.room_description,
            beds_count: this.beds_count, 
            capacity: this.capacity,
        };
    }
}

