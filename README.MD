I. Introduce
   ChicLightingAndDesign is a PHP-based web application developed to manage and display lighting products. The project is structured in a modular way, separating admin management, business logic, database handling, and user interface. It uses Apache with mod_rewrite for clean URLs and follows a clear folder organization to make development and maintenance easier. The system supports product browsing, cart and checkout features, as well as an admin panel for managing data.

II. How to run Code
   1. Turn On MOD_REWRITE
      xampp/apache/cpnf/httpd.conf
      change LoadModule rewrite_module modules/mod_rewrite.so
      restart Apache
   2. Copy folder "ChicLightingAndDesign" to "htdocs"
      htdocs/ChicLightingAndDesign
   3. Run code with link localhost/ChicLightingAndDesign

II. Project Structure

ChicLightingAndDesign
├── admin/                            
│   ├── home_admin.php                   # Admin main dashboard page
│   ├── login                            # Admin login handler/pages
│   ├── logout                           # Admin logout handler
│   └── register                         # Admin registration handler/pages
│
├── api/                               
│   └── api_database.php                 # Database API endpoints (CRUD, AJAX)
│
├── assets/                         
│   ├── css/                             # Stylesheets
│   └── img/                             # Images (products, banners, UI)
│
├── database/                            
│   ├── db.php                           # Database connection setup
│   ├── dbhelper.php                     # Common database helper functions
│   └── init.php                         # Database initialization / seed script
│
├── includes/                            # Reusable layout components
│   ├── hoem_header.php                  # Website header (navbar, meta, CSS)
│   └── home_footer.php                  # Website footer
│
├── modules/                             
│   ├── brand/                           # Brand management logic
│   ├── cart/                            # Shopping cart logic
│   ├── category/                        # Category management logic
│   ├── order/                           # Order processing logic
│   ├── product/                         # Product management logic
│   ├── user/                            # User authentication & profile logic
│   └── feedback/                        # User feedback & reviews logic
│
├── pages/                               
│   ├── home_page.php                    # Homepage
│   ├── about.php                        # About us page
│   ├── brand.php                        # Brand listing page
│   ├── category.php                     # Category listing page
│   ├── product.php                      # Product listing page
│   ├── product-detail.php               # Product detail page
│   ├── contact.php                      # Contact page
│   ├── gallery.php                      # Image gallery page
│   ├── check_out.php                    # Checkout page (legacy/duplicate)
│   ├── check_out.php                    # Checkout page (duplicate entry)
│   ├── cart.php                         # Shopping cart page
│   └── checkout.php                     # Checkout page (main)
│
├── .htaccess                            # Apache configuration (rewrite, security)
├── config.php                           # Global configuration constants
├── index.php                            # Application entry point
└── README.md                            # Project documentation
