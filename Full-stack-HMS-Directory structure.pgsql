Fullstack-Hotel-Management-System(no framework) /
├── backend/                                    # PHP backend
│   │  
│   ├── public/                                 # Web-accessible entry point
│   │   └── index.php                           # Front controller 
│   │ 
│   ├── config/                                 # App configuration
│   │   ├── config.php                          # Global config
│   │   ├── dbConnect.php                       # DB config
│   │   └── .env                                # Environment variables 
│   │     
│   ├── core/                                   # Core libraries/utilities 
│   │   ├── Router.php                    
│   │   ├── Request.php                   
│   │   ├── Response.php                  
│   │   ├── Auth.php                      
│   │   ├── Database.php                 
│   │   └── Logger.php         
│   │     
│   ├── app/                                    # Application Logic 
│   │   ├── controllers/                        # Controllers for each Domain
│   │   │   ├── GuestController.php
│   │   │   ├── RoomTypeController.php
│   │   │   ├── RoomController.php
│   │   │   ├── ReservationController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── BillingController.php
│   │   │   ├── ServiceController.php
│   │   │   ├── RoomServiceController.php
│   │   │   ├── StaffController.php
│   │   │   ├── HousekeepingController.php
│   │   │   └── FeedbackController.php 
│   │   │ 
│   │   ├── models/                             # Data Models
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
│   │   │   
│   │   ├── services/                           #Business logic
│   │   │   ├── ReservationService.php
│   │   │   ├── BillingService.php
│   │   │   └── NotificationService.php   
│   │   │ 
│   │   ├── middleware/                         # Middleware for request filtering
│   │   │   ├── AuthMiddleware.php
│   │   │   └── SessionMiddleware.php 
│   │   │ 
│   │   ├── validators/                         # Validation logic
│   │   │   └── Validator.php  
│   │   │    
│   │   ├── helpers/                            # Helper utilities
│   │   │   └── helper.php    
│   │   │          
│   │   └── auth/                               # Auth-specific scripts
│   │       ├── Login.php   
│   │       ├── register.php                   
│   │       └── resetPassword.php                 
│   │   
│   ├── routes/                           # Route definitions
│   │   ├── api.php                       # API routing
│   │   └── web.php                       # Optional backend-rendered view 
│   │
│   ├── storages/                            
│   │   ├── logs/ 
│   │   │   └── error.log     
│   │   └── uploads/    
│   │       └── receipts/                    
│   │
│   ├── tests/  
│   │   ├── RoomTest.php                  # Unit or integration tests
│   │   └── GuestTest.php                 
│   │
│   └── index.php                         # Alternative entry point (CLI/API testing)
│
├── frontend/                             # Client-side static UI
│   ├── public/                           # Public HTML entry (for hosting)
│   │   └── index.html  
│   │
│   ├── pages/                            # Page Templates
│   │   ├── index.html  
│   │   ├── booking.html
│   │   ├── room-detail.html 
│   │   ├── feedback.html 
│   │   ├── login.html 
│   │   └── dashboard.html 
│   │
│   ├── components/                       # HTML fragments
│   │   ├── header.html
│   │   ├── footer.html
│   │   └── room-card.html 
│   │                        
│   ├── styles/                           # CSS
│   │   ├── main.css
│   │   ├── booking.css 
│   │   ├── dashboard.css   
│   │   ├── responsive.css  
│   │   └── thems/ 
│   │       └── default.css   
│   │          
│   ├── scripts/                          # JavaScript
│   │   ├── main.js 
│   │   ├── booking.js 
│   │   ├── feedback.js 
│   │   ├── auth.js  
│   │   ├── dashboard.js      
│   │   └── utils/  
│   │       ├── api.js                    # API fetch wrappers
│   │       └── dom.js                    # DOM helper functions    
│   │         
│   ├── assets/                           # Static assets
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
