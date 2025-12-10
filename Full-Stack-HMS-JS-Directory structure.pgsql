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
├── frontend Hotel Management System  (JavaScript, HTML, CSS)
│   │
│   ├── index.html                              
│   │
│   ├── assets/
│   │   ├── images/
│   │   ├── icons/
│   │   └── fonts/
│   ├── css/                                   
│   │   ├── main.css
│   │   ├── variable.css
│   │   ├── reset.css
│   │   ├── layout/
│   │   │   ├── header.css
│   │   │   ├── sidebar.css
│   │   │   ├── grid.css
│   │   │   └── footer.css
│   │   ├── components/
│   │   │   ├── buttond.css
│   │   │   ├── card.css
│   │   │   ├── forms.css
│   │   │   └── tables.css
│   │   └── pages/
│   │       ├── dashboard.css 
│   │       ├── rooms.css 
│   │       ├── booking.css
│   │       ├── customers.css                  
│   │       └── setting.css 
│   │ 
│   ├── js/                                
│   │   ├── app.js     
│   │   ├── router.js       
│   │   ├── utils.js                       
│   │   ├── modules/                                     
│   │   │   ├── dashboard.module.js
│   │   │   ├── rooms.module.js
│   │   │   ├── booking.module.js
│   │   │   ├── guests.module.js
│   │   │   └── setting.module.js
│   │   ├── services/ 
│   │   │   ├── api.service.js
│   │   │   ├── rooms.service.js
│   │   │   ├── booking.service.js
│   │   │   └── guests.service.js
│   │   ├── data/ 
│   │   │   ├── roomData.js
│   │   │   ├── customerData.js
│   │   │   └── helper.js
│   │   └── components/  
│   │       ├── mavbar.js 
│   │       ├── sidebar.js                   
│   │       └── roomCard.js                               
│   │       
│   ├── pages/                          		       
│   │   ├── dashboard/
│   │   │   ├── index.html
│   │   │   ├── dashboard.css
│   │   │   └── dashboard.js
│   │   ├── rooms/
│   │   │   ├── rooms.html
│   │   │   ├── rooms.css
│   │   │   └── rooms.js
│   │   ├── booking/
│   │   │   ├── booking.html
│   │   │   ├── booking.css
│   │   │   └── booking.js
│   │   ├── customers/
│   │   │   ├── customers.html
│   │   │   ├── customers.css
│   │   │   └── customers.js
│   │   └── setting/  
│   │       ├── setting.html
│   │       ├── setting.css                  
│   │       └── setting.js                            
│   │    
│   └── uploads/                         # Local upload (e.g. preview)
│       └── temp/  
├── .env                                 # Global (shared) envioronment file 
├── .gitignore
│
└── README.md                            # Project documentation
