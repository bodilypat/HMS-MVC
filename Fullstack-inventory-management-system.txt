FullStack-Inventory-Management-System/
│
├── public(frontend)/                      	 	# Publicly accessible frontend + entry points
│   ├── index.php                           	# Main entry (login/dashboard redirect)
│	├── login.php                               # Login page
│	├── dashboard.php                           # Dashboard UI
│	├── product.php                             # Product UI
│	├── stock.php                               # Stock in / Out interface
│	├── orders.php                              # Order Management
│	├── customers.php                           # Customer record
│   │
│   ├── assets/                                 # Static assets
│   │   ├── css/
│   │   │   └── global.css
│   │   │
│   │   ├── js/
│   │   │   ├── main.js                         # Shared JavaScript
│   │	│   ├── products.js                     # Products logic
│   │   │   └── dashboard.js                    # Charts, stats
│   │   │
│   │   └── images/                             # Shared images, fonts, icons
│   │       └── logo.png
│   │
│	└── components/                             # Reuseable UI blocks (optional)
│		├── header.php                          
│		├── sidebar.php                         
│		└── footer.php 
│                         
├── api/                                        # Backend endpoint (AJAX/REST)
│   ├── auth/
│   │	├── login.php  
│	│	└── logout.php
│   │
│   ├── products/                      			# Product management page
│   │	├── list.php                         	
│   │	├── add.php                          	
│	│	├── update.php                         
│	│	└── delete.php
│   │
│  	├── stock/                          
│   │	├── stock_in.php   
│	│	└── stock_out.php    
│   │              
│	├── orders/
│	│	├── create.php
│	│	└── list.php
│   │
│	├── customers.php
│	│
│	└── reports/
│			└── export_csv.php
│   
├── app/                                        # Core application logic
│	├── controllers/ 
│   │   ├── ProductControllers 
│	│	├── InventoryController
│	│	├── AuthController.php
│	│	└── OrderController.php 
│	│	
│	├── models/                                 # Database interaction Layer
│	│   ├── Product.php
│	│   ├── User.php
│   │   ├── Inventory.php
│	│	└── Order.php 
│	│
│	└── helpers/                                # Utility classes and services
│		├── Database.php                        # DB connecting (PDO) 
│		├── Auth.php                            # Auth/session utilities
│		├── Response.php                        # Standardized API responses
│		├── Validator.php                       # In put validation
│		└── Logger.php                          # Action / error Logs
│	
├── config/
│	├── config.php                              # App settings
│	└── database.php                            # PDO connection Logs
│                           
├── uploads/
├── logs/
├── vendor/
├── .htaccess
│		
│	
└── README.md  