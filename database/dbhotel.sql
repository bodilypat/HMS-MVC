CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('Admin','Manager','Receptionist','Staff','Guest') NOT NULL DEFAULT 'Guest',
    phone_number VARCHAR(20),
    status ENUM('Active','Inactive') DEFAULT 'Active',
    ceate_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

/* Guests table */
CREATE TABLE guests (
    guest_id INT AUTO_INCREMENT PRIMARY KEY,          					-- Unique ID for each guest
    first_name VARCHAR(100) NOT NULL,                 					-- Corrected spelling of 'first_name'
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,               					-- Added email data type and uniqueness constraint
    phone_number VARCHAR(20),                         					-- Adjusted to phone number format (can change the size if needed)
    address TEXT,                                     					-- Text for storing guest address, can be longer than VARCHAR
    id_type ENUM('Passport', 'National ID','Driver Lincence') NOT NULL, -- Enum for id_type to restrict values
    id_number VARCHAR(50) NOT NULL,                  					-- id_number should store the actual ID or passport number
    dob DATE NOT NULL,                                					-- Date of Birth (DOB)
    nationality VARCHAR(50) DEFAULT 'Unknow',,                          -- Nationality can be a string
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                     -- Check-in date
    updated_at TIMESTAMP CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  -- Check-out date
);

/* Room_types table  */
CREATE TABLE room_types (
    room_type_id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(50) UNIQUE NOT NULL, -- e.g., Single, Double
    description TEXT,
    base_price DECIMAL(10, 2) NOT NULL CHECK (base_price >= 0)
	default_capacity INT NOT NULL DEFAULT 1 CHECK (default_capacity > 0),
	bed_count INT NOT NULL DEFAULT 1 CHECK (bed_count > 0),
	amenities TEXT,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT TIMESTAMP
);

/* Rooms table */
CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,                    
    room_number VARCHAR(10) NOT NULL,                            
    room_type_id INT NOT NULL,  
    floor_number INT NOT NULL CHECK (floor_number >= 0),                                   
    price_per_night DECIMAL(10, 2) NOT NULL CHECK (price_per_night >= 0),                     
    room_status ENUM('Available', 'Occupied', 'Maintenance') NOT NULL DEFAULT 'Available', 
    room_description TEXT,                                       
    beds_count INT NOT NULL CHECK (beds_count),                                     
    capacity INT NOT NULL CHECK (capacity >= beds_count),                                       
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (room_type_id) REFERENCES room_types(room_types_id) ON DELETE RESTRICT 
);

/* Reservation table */
CREATE TABLE reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,                  
    guest_id INT NOT NULL,                                           
    room_id INT NOT NULL,                                           
    check_in DATE NOT NULL,                                          
    check_out DATE NOT NULL,
	number_of_guests INT NOT NULL DEFAULT 1 CHECK (number_of_checks > 0),
    reservation_status ENUM('Pending','Confirmed','Checked-in','Checked-out','Cancelled') NOT NULL DEFAULT 'Pending',  
    payment_status ENUM('Pending','Paid','Partially Paid','Refunded') NOT NULL DEFAULT 'Pending',
	booking_source ENUM('Website','Phone','Walk-in','Traval Agency','OTA') NOT NULL 'Website',
	special_request TEXT,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_date (check_in <= check_out),   
    CONSTRAINT fk_quest FOREIGN KEY (quest_id) REFERENCES guests(guest_id) ON DELETE CASCADE,  
    CONSTRAINT fk_room FOREIGN KEY(room_id) REFERENCES rooms(room_id) ON DELETE SET NULL               
);

/* Payments table */
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,                              
    reservation_id INT NOT NULL,                                              
    amount_paid DECIMAL(10, 2) NOT NULL CHECK (amount_paid >= 0),
	currency 
    payment_date DATETIME NOT NULL,                                          
    payment_method ENUM('Credit Card', 'Cash', 'Online Transfer', 'Other') NOT NULL, 
    payment_status ENUM('Completed', 'Pending', 'Failed') NOT NULL,           
    CONSTRAINT fk_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE,  
    CONSTRAINT chk_amount_paid CHECK (amount_paid >= 0)                      
);

/* Billings table */
CREATE TABLE billings (
    billing_id INT AUTO_INCREMENT PRIMARY KEY,                              
    reservation_id INT NOT NULL,                                             
    service_charge DECIMAL(10, 2) DEFAULT 0.00,                             
    discount DECIMAL(10, 2) DEFAULT 0.00,                                    
    total_amount DECIMAL(10, 2) NOT NULL,                                   
    payment_status ENUM('Paid', 'Unpaid') NOT NULL,                          
    CONSTRAINT fk_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE, 
    CONSTRAINT chk_total_amount CHECK (total_amount >= 0)                    
);

/* services table */
CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    service_type VARCHAR(100) NOT NULL,
    category VARCHAR(50) DEFAULT NULL,	
    description TEXT,
    price DECIMAL(10, 2) NOT NULL CHECK (price >= 0),
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

/* Room_services table */
CREATE TABLE room_services (
    room_service_id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    service_id INT NOT NULL,
    service_request_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    service_status ENUM('Requested', 'In Progress', 'Delivered','Cancelled') NOT NULL DEFAULT 'Requested',
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_service_request_time CHECK (service_request_time <= NOW()),
	
    FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE SET NULL
);

/* staff table */
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

/* Housekeeping table */
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

/* Feedback Table */
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

