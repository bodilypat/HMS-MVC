Full-stack-Hotel-Management-System(no framework) /
├── backend/                                    
│   │  
│   ├── public/                                       # Publicly accessible (document root)
│   │   └── index.php                                 # Entry point / Front controller
│   │ 
│   ├── config/                                       # Configuration files
│   │   ├── config.php                                # General config
│   │   ├── dbConnect.php                             # DB connection
│   │   └── .env                                      # Environment variables 
│   │     
│   ├── core/                                         # Core libraries and infrastructure  
│   │   ├── Router.php                    
│   │   ├── Request.php                   
│   │   ├── Response.php                  
│   │   ├── Auth.php                      
│   │   ├── Database.php                 
│   │   └── Logger.php         
│   │     
│   ├── app/                                   
│   │   ├── controllers/                              # HTTP Controllers
│   │   │   ├── BaseController.php
│   │   │   ├── guest/
│   │   │   │   └── GuestController.php  
│   │   │   ├── room/
│   │   │   │   ├── RoomController.php
│   │   │   │   └── RoomTypeController.php
│   │   │   ├── reservation/
│   │   │   │ 	└── reservationController.php
│   │   │   ├── payment/
│   │   │   │   ├── PaymentController.py
│   │   │   │   └── BillingController.php
│   │   │   ├── service/
│   │   │   │   ├── ServiceController.php
│   │   │   │   ├── RoomServiceController.php
│   │   │   │   └── HousekeepingController.php
│   │   │   ├── staff/
│   │   │   │   └── StaffController.php  
│   │   │   └── feedback/
│   │   │       └── FeedbackController.php 
│   │   │ 
│   │   ├── services/                                 # Business Logic
│   │   │   ├── BaseService.php
│   │   │   ├── guest/
│   │   │   │   └── GuestService.php  
│   │   │   ├── room/
│   │   │   │   ├── RoomService.php
│   │   │   │   └── RoomTypeService.php
│   │   │   ├── reservation/
│   │   │   │ 	└── ReservationService.php
│   │   │   ├── payment/
│   │   │   │   ├── PaymentService.py
│   │   │   │   └── BillingService.php
│   │   │   ├── service/
│   │   │   │   ├── ServiceService.php
│   │   │   │   ├── RoomServiceService.php
│   │   │   │   └── HousekeepingService.php
│   │   │   ├── staff/
│   │   │   │   └── StaffService.php  
│   │   │   ├── feedback/
│   │   │   │   └── FeedbackService.php  
│   │   │   ├── auth/
│   │   │   │   └── AuthService.php  
│   │   │   └── notification/
│   │   │       └── NotificationService.php 
│   │   ├── models/                                    # Data Models (ORM-style)
│   │   │   ├── BaseModel.php
│   │   │   ├── guest/
│   │   │   │   └── Guest.php  
│   │   │   ├── room/
│   │   │   │   ├── Room.php
│   │   │   │   └── RoomType.php
│   │   │   ├── reservation/
│   │   │   │ 	└── Reservation.php
│   │   │   ├── payment/
│   │   │   │   ├── Payment.php
│   │   │   │   └── Billing.php
│   │   │   ├── service/
│   │   │   │   ├── Service.php
│   │   │   │   ├── RoomService.php
│   │   │   │   └── Housekeeping.php
│   │   │   └── feedback/
│   │   │       └── Feedback.php 
│   │   │ 
│   │   ├── middleware/                        # HTTP Middleware
│   │   │   ├── AuthMiddleware.php
│   │   │   └── SessionMiddleware.php 
│   │   │ 
│   │   ├── validators/                        # Input validation logic
│   │   │   ├── Validator.php
│   │   │   └── GuestValidator.php  
│   │   │    
│   │   ├── helpers/                           # Global utility functions
│   │   │   ├── helper.php
│   │   │   └── DateHelper.php    
│   │   │          
│   │   └── auth/                              # Auth-related scripts (procedural/CLI)
│   │       ├── Login.php   
│   │       ├── register.php                   
│   │       └── resetPassword.php                 
│   │   
│   ├── routes/                                # Route definitions
│   │   ├── api.php                            # API routing
│   │   └── web.php                                 
│   │
│   ├── storages/                            
│   │   ├── logs/ 
│   │   │   └── error.log     
│   │   └── uploads/    
│   │       └── receipts/                    
│   │
│   ├── tests/  
│   │   ├── RoomTest.php                       # Unit or integration tests
│   │   └── GuestTest.php                 
│   │
│   └── index.php                              # Alternative entry point (CLI/API testing)
│
├── frontend Hotel Management System  (MVC REST API with JavaScript, HTML, CSS)
│   │
│   ├── index.html                              
│   │
│   ├── css/                                   
│   │   ├── layout.css
│   │   ├── components.css
│   │   ├── pages.css
│   │   └── variables.css
│   │ 
│   ├── js/     
│   │   │                            
│   │   ├── controllers/                                # MVC controller
│   │   │   ├── roomController.js
│   │   │   ├── guestController.js
│   │   │   ├── bookingController.js
│   │   │   └── authController.js
│   │   ├── models/                                     # Data models / classes
│   │   │   ├── Room.js
│   │   │   ├── Guest.js
│   │   │   ├── Book.js
│   │   │   └── Auth.js
│   │   ├── views/                                      # Page level view logic
│   │   │   ├── roomPage.js
│   │   │   ├── guestPage.js
│   │   │   ├── bookingPage.js
│   │   │   └── authPage.js
│   │   ├── services/ 
│   │   │   ├── roomService.js
│   │   │   ├── guestService.js
│   │   │   ├── bookingService.js
│   │   │   └── authService.js
│   │   ├── utils/ 
│   │   │   ├── validation.js
│   │   │   ├── formatDate.js
│   │   │   └── helper.js
│   │   └── app.js                               
│   │       
│   ├── pages/                          		       
│   │   ├── login.html
│   │   ├── room.html
│   │   ├── guest.html
│   │   └── booking.html                                    
│   │    
│   └── uploads/                         # Local upload (e.g. preview)
│       └── temp/  
├── .env                                 # Global (shared) envioronment file 
├── .gitignore
│
└── README.md                            # Project documentation
