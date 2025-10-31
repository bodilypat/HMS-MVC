// Frontend/js/models/Book.js

export default class Booking {
    constructor({
        booking_id = null,
        guest_id = null,
        room_id = null,
        check_in_date = '',
        check_out_date = '',
        status = 'pending',
        total_price = 0
    }) {
        Object.assign(this, {
            booking_id,
            guest_id,
            room_id,
            check_in_date,
            check_out_date, 
            status,
            total_price
        });
    }
    static fromJSON(json) {
        return new Booking(json);
    }
    toJSON() {
        return { ...this };
    }
}