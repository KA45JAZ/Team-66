# Team-66

This project is a e-commerce website named GoodFit. GoodFit sells clothes of the sport varity. It is a fully functional shopping experiance with secure authentication, product browsing, basket management, order processing and a admin inventory system. The platform is built using PHP, HTML, MySQL, CSS and JavaScript.

**Contributors:**

- Jaspinder Shergill - 240336662
- Nakib Ahsan - 240186207
- Yeasin Bhuiyan - 240219620
- Jasandeep Gill - 240188175
- Jasroop Kaur - 240089609
- Amanda Uche - 240209713
- Abdulahi Adeed - 240364562
- Witold Horobiowski - 230411744
  
**Features**
Customer Features

- Account Registration and Secure Login
- Password change functionality
- Browse, search, and filter products
- Add/update/remove basket items
- Checkout with dummy payment
- View past orders & order status
- Return purchased products
- Update personal details
- Rate & review products

Admin Features

- Admin registration & login
- Manage customers (add/update/delete)
- Process orders & update statuses
- Full inventory management (add/edit/delete products)
- Real‑time stock reporting
- Low‑stock alerts
- Manage incoming stock

System Features

- Secure authentication
- Prepared statements for SQL injection protection
- Session‑based access control
- Soft‑delete system
- Responsive UI with light/dark mode
- Deployed online
- GitHub version control

**Tech List**
The list of what software and coding languages used
Frontend:

- HTML5
- CSS3
- JavaScript

Backend:

- PHP
- MySQL
Tools & Deployment:

- GitHub
- Trello (project management)
- Hosting server VirtualMin

**Project Structure**
All php files exist ajacent to each other
Contains exported MySQL database code
CSS Styling scripts exist in css folder
Images contians any icons used
Product images are stored in products/(category name)
JavaScript folder is empty as code is within the php file

List of Files and Folders:

- css/
  - dark.css
  - light.css
- images/
  - (any icons used)
- products/
  - mens
  - womens
  - kids
  - accessories
  - trainers
- cs2team66_db.sql
- abouts.php
- account_settings.php
- account.php
- add_to_basket.php
- admin_add_category.php
- admin_add_product.php
- admin_categories.php
- admin_check.php
- admin_dashboard.php
- admin_delete_category.php
- admin_delete_product.php
- admin_edit_category.php
- admin_edit_product.php
- admin_orders.php
- admin_products.php
- admin_view_order.php
- auth_check.php
- basket.php
- category.php
- chatbot.php
- checkout.php
- connectdb.php
- contact_process.php
- contact.php
- customer_dashboard.php
- faq.php
- footer.php
- forgot_password.php
- index.php
- login_process.php
- login.php
- logout.php
- navbar.php
- no_results_found.php
- order_success.php
- order_view.php
- orders.php
- password_change_process.php
- password_change.php
- place_order.php

**Database Stucture**
List of tables used:

- users
- categories
- products
- cart
- cart_items
- orders
- orders_items
- contact_messages
- reviews
- wishlist

**Security**
List of some of the security features;

- Password hashing (password_hash)
- Prepared statements
- Session‑based authentication
- Role‑based access control
- Input validation
- XSS protection
- Soft delete system
