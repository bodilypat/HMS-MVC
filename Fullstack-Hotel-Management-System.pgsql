Fullstack-Hotel-Management-System/
├── backend/                              # Backend API & business logic (PHP)
│   │     
│   ├── config/                           # Configuration files
│   │   ├── config.php                    # App constants, environment variables
│   │   └── dbconnect.php                    # PDO DB connection handler
│   │     
│   ├── core/ 
│   │   ├── Helper.php  
│   │   ├── Validator.php  
│   │   └── SessionMiddleware.php         # Renamed from session.php
│   │     
│   ├── auth/                             # Authentication Handler
│   │   ├── login.php                     # Staff/Admin Login handler
│   │   ├── logout.php                    # Session destroy Logic
│   │   └── AuthController.php            # Optional: centralize auth logic
│   │   
│   ├── controllers/                      # API controller
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
│   ├── models/                           # Business models(ORM style)
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
│   │   
│   ├── routes/                           # Route definitions
│   │   ├── api.php                       # API/ endpoint definitions
│   │   └── web.php                       # Optional backend-rendered pages
│   │
│   ├── views/                            # Option Rendered Views
│   │   ├── emails/  
│   │   └── templates/                    # Optional admin teamplates
│   │
│   ├── uploads/    
│   │   └── receipts/                     # Uploaded payment receipts 
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
└── README.md
