// Frontend/js/models/Guest.js

export default class Guest {
    constructor({
        guest_id,
        first_name,
        last_name,
        email,
        phone_number,
        address,
        id_type,
        id_number,
        dob,
        nationality = 'Unknown',
        created_at,
        updated_at
    }) {
        this.guest_id = guest_id;
        this.first_name = first_name;
        this.last_name = last_name;
        this.email = email;
        this.phone_number = phone_number;
        this.address = address;
        this.id_type = id_type;
        this.id_number = id_number;
        this.dob = dob;
        this.nationality = nationality;
        this.created_at = created_at;
        this.updated_at = updated_at;
    }

    static fromJSON(data) {
        return new Guest(data);
    }
    toJSON() {
        return {
            first_name: this.first_name,
            last_name: this.last_name,
            email: this.email,
            phone_number: this.phone_number,
            address: this.address,
            id_type: this.id_type,
            id_number: this.id_number,
            dob: this.dob,
            nationality: this.nationality
        };
    }
}