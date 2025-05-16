Fullstack-Hotel-Management-System/
├── backend/                              # Backend API & business logic (PHP)
│   │     
│   ├── config/                           # Configuration files
│   │   ├── config.php                    
│   │   └── dbconnect.php                 # PDO DB connection handler
│   │     
│   ├── core/                             # Core utilities and middleware
│   │   ├── Helper.php  
│   │   ├── Validator.php  
│   │   └── SessionMiddleware.php         
│   │     
│   ├── auth/                             # Authentication Logic
│   │   ├── login.php                    
│   │   ├── logout.php                  
│   │   └── AuthController.php            
│   │   
│   ├── controllers/                      # Business logic controllers (API layer)
│   │   ├── AuthController.php   
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
│   │   ├── api.php                       # API routing
│   │   └── web.php                       # Optional backend-rendered view 
│   │
│   ├── views/                            # Server-rendered views (Optional)
│   │   ├── emails/  
│   │   └── templates/                    # Admin UI templates, if any
│   │
│   ├── uploads/    
│   │   └── receipts/                     # Server-side file storage
│   │
│   └── index.php                         # API entry point (if using routing manually)
│
├── frontend/                             # Client-side application
│   ├── pages/   
│   │   ├── index.html  
│   │   ├── booking.html
│   │   ├── roomd.html 
│   │   ├── feedback.html 
│   │   ├── login.html 
│   │   └── dashboard.html                       
│   ├── css/  
│   │   ├── main.css
│   │   ├── booking.css 
│   │   ├── dashboard.css   
│   │   └── responsive.css                 
│   ├── js/
│   │   ├── main.js 
│   │   ├── booking.js 
│   │   ├── feedback.js 
│   │   ├── auth.js    
│   │   └── dashboard.js                  
│   ├── components/
│   │   ├── header.html
│   │   ├── footer.html
│   │   └── room-card.html                    
│   ├── images/ 
│   │   ├── logo.png
│   │   ├── rooms/
│   │   └── icons/ 
│   │       ├── checkin.svg  
│   │       └── service.svg                     
│   ├── assets/ 
│   │   └── vendors/                  
│   │    
│   └── uploads/                           # Client-side uploads (optionsal)
├── .env                                   # Environment variables
├── .gitignore
│
└── README.md
