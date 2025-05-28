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
│   ├── app/                             
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
│   │   ├── services/                       
│   │   │   ├── api.php
│   │   │   └── web.php   
│   │   ├── middleware/                       
│   │   │   ├── AuthMiddleware.php
│   │   │   └── SessionMiddleware.php 
│   │   ├── validators/                       
│   │   │   └── Validator.php     
│   │   ├── helpers/
│   │   │   └── helper.php             
│   │   └── auth/   
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
│   │   │   └── resetPassword.php     
│   │   └── uploads/    
│   │       └── resetPassword.php                    
│   │
│   ├── tests/  
│   │   ├── RoomTest.php  
│   │   └── GuestTest.php                 # Server-side file storage
│   │
│   └── index.php                         # API entry point (if using routing manually)
│
├── frontend/                            
│   ├── public/                           
│   │   └── index.html  
│   ├── pages/   
│   │   ├── index.html  
│   │   ├── booking.html
│   │   ├── room-detail.html 
│   │   ├── feedback.html 
│   │   ├── login.html 
│   │   └── dashboard.html 
│   ├── components/
│   │   ├── header.html
│   │   ├── footer.html
│   │   └── room-card.html                         
│   ├── styles/  
│   │   ├── main.css
│   │   ├── booking.css 
│   │   ├── dashboard.css   
│   │   ├── responsive.css  
│   │   └── thems/ 
│   │       └── default.css             
│   ├── scripts/
│   │   ├── main.js 
│   │   ├── booking.js 
│   │   ├── feedback.js 
│   │   ├── auth.js  
│   │   ├── dashboard.js      
│   │   └── utils/  
│   │       ├── api.js  
│   │       └── dom.js                                
│   ├── assets/ 
│   │   ├── images/
│   │   │   ├── logo.png
│   │   │   ├── rooms/
│   │   │   └── icons/ 
│   │   │       ├── checkin.svg  
│   │   │       └── service.svg  
│   │   └── vendors/  
│   │       └── flatpicker/                                   
│   │    
│   └── uploads/                          
│       └── temp/  
├── .env                                   
├── .gitignore
│
└── README.md
