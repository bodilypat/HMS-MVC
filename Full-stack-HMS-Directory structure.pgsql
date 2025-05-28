Fullstack-Hotel-Management-System(no framework) /
├── backend/                              # Backend API & business logic (PHP)
│   │  
│   ├── public/                           # Public web root (entry point)
│   │   └── index.php                     # Front controller (handles all request)
│   ├── config/                           
│   │   ├── config.php                    # App-wide settings (timezone, debug, etc)
│   │   ├── dbConnect.php                 # Database configuration
│   │   └── .env                          # Environment variables 
│   │     
│   ├── core/                             # Core utilities and middleware
│   │   ├── Router.php                    # Lightweight router
│   │   ├── Request.php                   # Input abstraction
│   │   ├── Response.php                  # JSON response builder
│   │   ├── Auth.php                      # Auth utitlity class
│   │   ├── Database.php                  # PDO connection manager 
│   │   └── Logger.php         
│   │     
│   ├── app/                             # Authentication Logic
│   │   ├── auth/ 
│   │   │   ├── login.php      
│   │   │   ├── register.php       
│   │   │   └── resetPassword.php      
│   │   ├── controllers/
│   │   │   ├── GuestController.php
│   │   │   ├── RoomTypegController.php
│   │   │   ├── RoomController.php
│   │   │   ├── ReservationController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── BillingController.php
│   │   │   ├── ServiceController.php
│   │   │   ├── RoomServiceController.php
│   │   │   ├── StaffController.php
│   │   │   ├── HousekeepingController.php
│   │   │   └── FeedbackController.php 
│   │   ├── models/
│   │   │   ├── Guest.php     
│   │   │   ├── RoomType.php
│   │   │   ├── Room.php 
│   │   │   ├── Reservation.php
│   │   │   ├── Payment.php
│   │   │   ├── Billing.php
│   │   │   ├── Service.php
│   │   │   ├── RoomService.php
│   │   │   ├── Staff.php
│   │   │   ├── Housekeeping.php
│   │   │   └── Feedback.php 
│   │   ├── routes/                       # Route definitions
│   │   │   ├── api.php
│   │   │   └── web.php   
│   │   ├── storages/
│   │   │   ├── logs/
│   │   │   │   └── dbconnect.php    
│   │   │   └── dbconnect.php             # DB connection settings
│   │   └── tests/                   # Optional: Middleware for auth, logging
│   │       └── AuthMiddleware.php                 
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
