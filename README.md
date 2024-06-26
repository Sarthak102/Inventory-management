# Inventory Management System

This project is an Inventory Management System built with PHP, MySQL, HTML, and CSS. It allows users to add vendors, add products, issue products, view available products, and generate inventory reports.

## Features

- Add vendors
- Add products associated with vendors
- Issue products
- View available products with the ability to increment quantities
- Generate inventory reports

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/Sarthak102/inventory-management-system.git
   cd inventory-management-system
   ```

2. **Set up the database:**

   - Create a database named `inventory`:

   ```sql
   CREATE DATABASE inventory;
   USE inventory;
   ```

3. **Configure the database connection:**

   - Update the `db.php` file with your MySQL database credentials.

   ```php
   <?php
   $servername = "your_servername";
   $username = "your_username";
   $password = "your_password";
   $dbname = "inventory";
   $port = "your_port"

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname, $port);

   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

4. **Start the server:**

   - If you are using XAMPP or WAMP, place the project folder in the `htdocs` directory.
   - Start Apache and MySQL services.

5. **Access the application:**

   - Open your web browser and go to `http://localhost/inventory-management-system`.

## Database Tables

Execute the following SQL commands to set up the necessary tables in your MySQL database:

```sql
CREATE TABLE vendors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_info TEXT
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    available_quantity INT NOT NULL,
    vendor_id INT,
    category_id INT,
    FOREIGN KEY (vendor_id) REFERENCES vendors(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE inventory_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    date DATE NOT NULL,
    issued_quantity INT,
    issued_by VARCHAR(255),
    balance_quantity INT,
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

## File Structure

```
inventory-management-system/
│
├── db.php                # Database connection file
├── navbar.php            # Navbar component
├── add_vendor.php        # Add vendor form
├── add_product.php       # Add product form
├── issue_product.php     # Issue product form
├── view_products.php     # View available products
├── generate_report.php   # Generate inventory reports
├── styles.css            # CSS styles
├── inventory.sql         # SQL file to set up the database
└── README.md             # Project readme
```

## Screenshots

### Home Page
![image](https://github.com/Sarthak102/Inventory-management/assets/91387298/1c312692-4954-497c-b620-021edd2b501f)


### Add Vendor
![image](https://github.com/Sarthak102/Inventory-management/assets/91387298/a5b32569-5693-4dc7-a565-ee567dd09ded)


### Add Product
![image](https://github.com/Sarthak102/Inventory-management/assets/91387298/fa4d5768-c111-47ff-9b66-0ed380bb981e)

### Issue Products
![image](https://github.com/Sarthak102/Inventory-management/assets/91387298/ac1499da-1d8f-48c3-9c0b-c5685057f475)


### View Products
![image](https://github.com/Sarthak102/Inventory-management/assets/91387298/66d815cd-0c52-4262-8501-3d50c124920a)


### Generate Report
![image](https://github.com/Sarthak102/Inventory-management/assets/91387298/4d1eb7ca-ede9-4ae9-8bf6-ac1c90e9e6d0)

![image](https://github.com/Sarthak102/Inventory-management/assets/91387298/863590b3-c521-4d33-9111-6492d3d328ba)




## Contact

- **Author:** Sarthak Kamble
- **Email:** sarthakkamble101@gmail.com
- **GitHub:** [Sarthak102](https://github.com/Sarthak102)
- **LinkedIn:** [Sarthak Kamble](https://www.linkedin.com/in/sarthak-kamble-101/)
