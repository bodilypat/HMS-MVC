Fullstack-Hotel-Management-System/
├── backend/                              # Backend API & business logic (PHP)
│   │     
│   ├── config/                           # Configuration files
│   │   ├── config.php                    # DB config, constants
│   │   └── dbconnectp                    # PDO connection handler
│   │     
│   ├── auth/                             
│   │   ├── loginphp                      # Handle login
│   │   ├── logout.php                    # Handle logout
│   │   └── session.php                   # Session check middleware
│   │   
│   ├── controllers/                      
│   │   ├── UserController.php            
│   │   ├── GuestController.php
│   │   ├── BookingController.php
│   │   ├── RoomController.php
│   │   ├── ReservationController.php
│   │   ├── PaymentController.php
│   │   ├── StaffController.php
│   │   ├── RoomServiceController.php
│   │   ├── BillingController.php
│   │   └── FeedbackController.php
│   │
│   ├── models/
│   │   ├── User.php            
│   │   ├── Guest.php
│   │   ├── Booking.php
│   │   ├── Room.php
│   │   ├── Reservation.php
│   │   ├── Payment.php
│   │   ├── Staff.php
│   │   ├── RoomService.php
│   │   ├── Billing.php
│   │   └── Feedback.php
│   ├── routes/    
│   │   ├── api.php                       # All API endpoints
│   │   └── web.php                       # Optional web-based routes
│   │
│   ├── views/    
│   │   ├── emails/  
│   │   └── templates/                    # Optional admin teamplates
│   │
│   ├── uploads/    
│   │   └── receipts/                     # Uploaded payment receipts 
│   │
│   ├── utils/    
│   │   ├── validator.php                 # Input validation
│   │   └── Helpers.php                   # Common utility functions  
│   │                         
│   └── index.php                         # Optional admin templates
│
├── frontend/                             
│   ├── index.html                        # Public landing page     
│   ├── booking.html                      # Booking form page(connected to bakend API)
│   ├── rooms.html                        # View available rooms
│   ├── feedback.html                     # Leave feedback post-stay
│   ├── login.html                        # Staff/Admin Login screen
│   ├── dashboard.html                    # Admin dashboard UI (optional frontend view)
│   │    
│   ├── css/                              # Organized by function/page
│   │   ├── style.css                     # Shared styles
│   │   ├── booking.css                   # Styles specific to booking page
│   │   ├── dashbord.css                  # Admin dashboard styles
│   │   └── responsive.css                # Media queries for mobile/tablets 
│   │                      
│   ├── js/                               # AJAX request, UI events , form validate
│   │   ├── main.js                       # General UI interactions (navbar, etc)
│   │   ├── booking.js                    # Booking form Logic and validation
│   │   ├── feedback.js                   # Feedback submission Logic
│   │   ├── auth.js                       # Login Logic (AJAX)
│   │   └── dashboard  .css               # Admin panel interactivity
│   │     
│   ├── images/                           # Room photos, icons, brading
│   │   ├── logo.png                      
│   │   ├── rooms/             
│   │   │   ├── room                      
│   │   │   └── icon                      
│   │   └── icons/                        
│   │       ├── checkin.svg                     
│   │       └── service.svg      
│   │
│   │   
│   ├── components/                       # Reusable HTML part for templating
│   │   ├── header.html 
│   │   ├── footer.html
│   │   └── room-card.html               
│   │
│   └── assets/                           # Bootstrap, Font Awesome, jQuery, etc
│       ├── footer.html
│   	└── vendors/                      # Third-party libraries (Bootstap, jQuery, etc)
│

