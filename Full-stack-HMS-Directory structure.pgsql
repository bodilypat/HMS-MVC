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
├── frontend/                                  # Client-side static UI
│   ├── public/                                # Public HTML entry (for hosting)
│   │   └── index.html  
│   │
│   ├── pages/                                 # Page Templates
│   │   ├── Guest/
│   │   ├── Room/
│   │   ├── Reservation/ 
│   │   ├── dashboard/ 
│   │   └── index.html                         # Homepage 
│   │
│   ├── components/                            # HTML UI components(reusable)
│   │   ├── layout/
│   │   ├── room/
│   │   ├── reservation/
│   │   └── feedback/
│   │                        
│   ├── styles/                                # CSS
│   │   ├── main.css                           # Global styles
│   │   ├── responsive.css                     # Media queries
│   │   ├── themes/ 
│   │   │   └── default.css
│   │   ├── guest/ 
│   │   │   └── auth.css
│   │   ├── room/ 
│   │   │   └── room.css
│   │   ├── reservation/ 
│   │   │    └── booking.css
│   │   └── dashboard/ 
│   │       └── dashboard.css   
│   │       
│   ├── scripts/                           		# JavaScript
│   │   ├── main.js                             # Entry point, global events
│   │   ├── utills/                             # Shared functions
│   │   │   ├── api.js                          # API request handler
│   │   │   └── dom.js                          # DOM utils
│   │   ├── guest/ 
│   │   │   ├── auth.js                         # Login / register
│   │   │   └── feedback.js
│   │   ├── room/ 
│   │   │   └── room.js
│   │   ├── reservation/ 
│   │   │    └── booking.js
│   │   └── dashboard/ 
│   │       └── dashboard.js    
│   │         
│   ├── assets/                          		 # Static assets
│   │   ├── images/
│   │   │   ├── logo.png
│   │   │   ├── rooms/
│   │   │   └── icons/ 
│   │   │       ├── checkin.svg  
│   │   │       └── service.svg  
│   │   │ 
│   │   └── vendors/  
│   │       └── flatpicker/                                   
│   │    
│   └── uploads/                         # Local upload (e.g. preview)
│       └── temp/  
├── .env                                 # Global (shared) envioronment file 
├── .gitignore
│
└── README.md                            # Project documentation
