CREATE TABLE guests (
    guest_id INT AUTO_INCREMENT PRIMARY KEY,          -- Unique ID for each guest
    first_name VARCHAR(100) NOT NULL,                 -- Corrected spelling of 'first_name'
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,               -- Added email data type and uniqueness constraint
    phone_number VARCHAR(15),                         -- Adjusted to phone number format (can change the size if needed)
    address TEXT,                                     -- Text for storing guest address, can be longer than VARCHAR
    id_type ENUM('Passport', 'ID card') NOT NULL,     -- Enum for id_type to restrict values
    id_number VARCHAR(50) NOT NULL,                   -- id_number should store the actual ID or passport number
    dob DATE NOT NULL,                                -- Date of Birth (DOB)
    nationality VARCHAR(50),                          -- Nationality can be a string
    check_in_date DATE,                               -- Check-in date
    check_out_date DATE,                              -- Check-out date
    CONSTRAINT chk_dates CHECK (check_in_date <= check_out_date)  -- Ensure check-out date is after check-in date
);


CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,                    
    room_number VARCHAR(10) NOT NULL,                            
    room_type ENUM('Single', 'Double', 'Suite', 'Other') NOT NULL, 
    floor_number INT NOT NULL,                                   
    price_per_night DECIMAL(10, 2) NOT NULL,                     
    room_status ENUM('Available', 'Occupied', 'Maintenance') NOT NULL, 
    room_description TEXT,                                       
    beds_count INT NOT NULL,                                     
    capacity INT NOT NULL,                                       
    CONSTRAINT chk_beds_capacity CHECK (beds_count <= capacity)  
);

CREATE TABLE reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,                  -- Unique reservation ID
    guest_id INT NOT NULL,                                           -- Foreign key referencing Guests.guest_id
    room_id INT NOT NULL,                                            -- Foreign key referencing Rooms.room_id
    check_in DATE NOT NULL,                                          -- Check-in date
    check_out DATE NOT NULL,                                         -- Check-out date
    reservation_status ENUM('Confirmed', 'Cancelled', 'Pending') NOT NULL,  -- ENUM for reservation status
    payment_status ENUM('Paid', 'Pending') NOT NULL,                 -- ENUM for payment status
    CONSTRAINT fk_guest FOREIGN KEY (guest_id) REFERENCES guests(guest_id) ON DELETE CASCADE,  -- Foreign key constraint for guest_id
    CONSTRAINT fk_room FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE SET NULL,  -- Foreign key constraint for room_id
    CONSTRAINT chk_dates CHECK (check_in <= check_out)               -- Check constraint to ensure check-in date is before check-out date
);



CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,                              -- Unique payment ID
    reservation_id INT NOT NULL,                                              -- Foreign key referencing Reservations.reservation_id
    amount_paid DECIMAL(10, 2) NOT NULL,                                      -- Amount paid (with two decimal places)
    payment_date DATETIME NOT NULL,                                           -- Date and time of the payment
    payment_method ENUM('Credit Card', 'Cash', 'Online Transfer', 'Other') NOT NULL, -- ENUM for payment method
    payment_status ENUM('Completed', 'Pending', 'Failed') NOT NULL,           -- ENUM for payment status
    CONSTRAINT fk_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE,  -- Foreign key constraint for reservation_id
    CONSTRAINT chk_amount_paid CHECK (amount_paid >= 0)                       -- Check constraint to ensure the amount paid is not negative
);


CREATE TABLE staffs (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,                              -- Unique staff ID
    first_name VARCHAR(100) NOT NULL,                                       -- Staff first name
    last_name VARCHAR(100) NOT NULL,                                        -- Staff last name
    role ENUM('Receptionist', 'Housekeeper', 'Manager', 'Other') NOT NULL,  -- ENUM for staff role
    email VARCHAR(255) NOT NULL UNIQUE,                                     -- Email with UNIQUE constraint
    phone_number VARCHAR(15),                                               -- Phone number (adjust length as needed)
    salary DECIMAL(10, 2) NOT NULL,                                         -- Salary with two decimal places
    hire_date DATE NOT NULL,                                                -- Hire date
    status ENUM('Active', 'Inactive') NOT NULL,                             -- ENUM for staff status
    CONSTRAINT chk_salary CHECK (salary >= 0)                               -- Check to ensure salary is not negative
);


CREATE TABLE housekeepings (
    housekeeping_id INT AUTO_INCREMENT PRIMARY KEY,                                  -- Unique housekeeping record ID
    room_id INT NOT NULL,                                                           -- Foreign key referencing Rooms.room_id
    staff_id INT NOT NULL,                                                          -- Foreign key referencing Staff.staff_id
    cleaning_date DATETIME NOT NULL,                                                -- Date and time of cleaning
    cleaning_status ENUM('Pending', 'In Process', 'Completed') NOT NULL,             -- ENUM for cleaning status
    CONSTRAINT fk_room FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE CASCADE, -- Foreign key constraint for room_id
    CONSTRAINT fk_staff FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE, -- Foreign key constraint for staff_id
    CONSTRAINT chk_cleaning_date CHECK (cleaning_date <= NOW())                       -- Check constraint to ensure cleaning_date is not in the future
);


CREATE TABLE room_services (
    room_service_id INT AUTO_INCREMENT PRIMARY KEY,                               -- Unique room service ID
    reservation_id INT NOT NULL,                                                  -- Foreign key referencing Reservations.reservation_id
    service_type ENUM('Food', 'Beverages', 'Other Requests') NOT NULL,             -- ENUM for service type
    service_request_time DATETIME NOT NULL,                                       -- Date and time the service was requested
    service_status ENUM('Requested', 'In Progress', 'Delivered') NOT NULL,        -- ENUM for service status
    CONSTRAINT fk_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE,  -- Foreign key constraint for reservation_id
    CONSTRAINT chk_service_request_time CHECK (service_request_time <= NOW())      -- Check constraint to ensure the service request time is not in the future
);


CREATE TABLE billings (
    billing_id INT AUTO_INCREMENT PRIMARY KEY,                              -- Unique billing ID
    reservation_id INT NOT NULL,                                             -- Foreign key referencing Reservations.reservation_id
    service_charge DECIMAL(10, 2) DEFAULT 0.00,                              -- Service charge (decimal with two decimal places)
    discount DECIMAL(10, 2) DEFAULT 0.00,                                    -- Discount (decimal with two decimal places)
    total_amount DECIMAL(10, 2) NOT NULL,                                    -- Total amount with two decimal places
    payment_status ENUM('Paid', 'Unpaid') NOT NULL,                          -- ENUM for payment status
    CONSTRAINT fk_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE,  -- Foreign key constraint for reservation_id
    CONSTRAINT chk_total_amount CHECK (total_amount >= 0)                    -- Check constraint to ensure total_amount is not negative
);

CREATE TABLE feedbacks (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,                                  -- Unique feedback ID
    guest_id INT NOT NULL,                                                       -- Foreign key referencing Guests.guest_id
    reservation_id INT NOT NULL,                                                 -- Foreign key referencing Reservations.reservation_id
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),                           -- Rating (1-5 stars) with check constraint
    comments TEXT,                                                               -- Comments about the feedback (use TEXT for potentially long feedback)
    feedback_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,                    -- Date and time when the feedback was submitted
    CONSTRAINT fk_guest FOREIGN KEY (guest_id) REFERENCES guests(guest_id) ON DELETE CASCADE, -- Foreign key constraint for guest_id
    CONSTRAINT fk_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE -- Foreign key constraint for reservation_id
);

