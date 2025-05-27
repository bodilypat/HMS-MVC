Fullstack-Hotel-Management-System(no framework) /
├── backend/                              # Backend API & business logic (PHP)
│   │  
│   ├── public/  
│   │   └── index.php              
│   ├── config/                           # Configuration files
│   │   ├── config.php                    
│   │   └── dbconnect.php                 # PDO DB connection handler
│   │     
│   ├── core/                             # Core utilities and middleware
│   │   ├── Helper.php  
│   │   ├── Validator.php  
│   │   └── SessionMiddleware.php         
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
│   │   │   └── api.php   
│   │   ├── core/
│   │   │   ├── Database.php              # PDO connection class
│   │   │   ├── Router.php                # Optional basic routing
│   │   │   ├── Response.php              # Helper for JSON repsonses
│   │   │   └── Auth.php                  # Authentication helper
│   │   ├── config/
│   │   │   ├── config.php
│   │   │   └── dbconnect.php             # DB connection settings
│   │   └── middleware/                   # Optional: Middleware for auth, logging
│   │       └── AuthMiddleware.php                 
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
