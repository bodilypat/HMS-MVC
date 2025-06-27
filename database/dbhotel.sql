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
    guest_id INT AUTO_INCREMENT PRIMARY KEY,          					
    first_name VARCHAR(100) NOT NULL,                 					
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,               					
    phone_number VARCHAR(20),                         					
    address TEXT,                                     					
    id_type ENUM('Passport', 'National ID','Driver Lincence') NOT NULL, 
    id_number VARCHAR(50) NOT NULL,                  					
    dob DATE NOT NULL,                                					
    nationality VARCHAR(50) DEFAULT 'Unknow',,                          
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                     
    updated_at TIMESTAMP CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
);

/* Room_types table  */
CREATE TABLE room_types (
    room_type_id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(50) UNIQUE NOT NULL, 
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
    beds_count INT NOT NULL CHECK (beds_count > 0),                                     
    capacity INT NOT NULL CHECK (capacity >= beds_count),                                       
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (room_type_id) REFERENCES room_types(room_type_id) ON DELETE RESTRICT 
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
    CONSTRAINT chk_date CHECK (check_in <= check_out),   
    FOREIGN KEY (quest_id) REFERENCES guests(guest_id) ON DELETE CASCADE,  
    FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE SET NULL               
);

/* Payments table */
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,                              
    reservation_id INT NOT NULL,                                              
    amount_paid DECIMAL(10, 2) NOT NULL CHECK (amount_paid >= 0),
    currency VARCHAR(3) NOT NULL DEFAULT 'USD',
    payment_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,                                          
    payment_method ENUM('Credit Card', 'Cash', 'Online Transfer', 'Other') NOT NULL, 
    payment_status ENUM('Completed', 'Pending', 'Failed') NOT NULL DEFAULT 'Pending',   
    transaction_reference VARCHAR(100), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	
    CONSTRAINT fk_payments_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE,            
);

/* Billings table */
CREATE TABLE billings (
    billing_id INT AUTO_INCREMENT PRIMARY KEY,                              
    reservation_id INT NOT NULL,                                             
    service_charge DECIMAL(10, 2) DEFAULT 0.00 	CHECK (service_charge >= 0),                             
    discount DECIMAL(10, 2) DEFAULT 0.00 CHECK (discount >= 0),                                    
    total_amount DECIMAL(10, 2) NOT NULL CHECK (total_amount >= 0),                                   
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
    staff_id INT AUTO_INCREMENT PRIMARY KEY,                              
    first_name VARCHAR(100) NOT NULL,                                       
    last_name VARCHAR(100) NOT NULL,                                        
    role ENUM('Receptionist', 'Housekeeper', 'Manager', 'Other') NOT NULL,  
    email VARCHAR(255) NOT NULL UNIQUE,                                     
    phone_number VARCHAR(15),                                               
    salary DECIMAL(10, 2) NOT NULL CHECK (salary >= 0),                                         
    hire_date DATE NOT NULL,                                               
    status ENUM('Active', 'Inactive') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

/* Housekeeping table */
CREATE TABLE housekeepings (
    housekeeping_id INT AUTO_INCREMENT PRIMARY KEY,                                  
    room_id INT NOT NULL,                                                           
    staff_id INT NOT NULL,                                                         
    cleaning_date DATETIME NOT NULL,                                               
    cleaning_status ENUM('Pending', 'In Process', 'Completed') NOT NULL,             
    CONSTRAINT fk_room FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE CASCADE, 
    CONSTRAINT fk_staff FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE, 
    CONSTRAINT chk_cleaning_date CHECK (cleaning_date <= NOW())                      
);

/* Feedback Table */
CREATE TABLE feedbacks (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,                                  
    guest_id INT NOT NULL,                                                       
    reservation_id INT NOT NULL,                                                 
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),                          
    comments TEXT,                                                               
    feedback_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,                    
    CONSTRAINT fk_guest FOREIGN KEY (guest_id) REFERENCES guests(guest_id) ON DELETE CASCADE,
    CONSTRAINT fk_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE 

