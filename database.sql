-- Run this in phpMyAdmin
CREATE DATABASE IF NOT EXISTS agrosmart_db;
USE agrosmart_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name, description) VALUES 
('Pigs', 'Quality pigs and pork products'),
('Goats', 'Healthy goats for meat and breeding'),
('Maize', 'Fresh maize and maize products'),
('Beans', 'Nutritious beans varieties'),
('Eggs', 'Fresh farm eggs'),
('Cassava', 'Cassava roots and flour');

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    category_id INT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    description TEXT,
    image VARCHAR(255),
    status ENUM('available', 'limited', 'sold_out') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(150) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_location VARCHAR(255),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash_on_delivery', 'mobile_money', 'bank_transfer') DEFAULT 'cash_on_delivery',
    status ENUM('pending', 'confirmed', 'processing', 'delivered', 'cancelled') DEFAULT 'pending',
    notes TEXT
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO products (name, category_id, price, stock_quantity, description, status) VALUES
('Live Pig - Medium', 1, 250000, 10, 'Healthy medium-sized pig, ready for fattening', 'available'),
('Live Pig - Large', 1, 450000, 5, 'Large mature pig, ready for slaughter', 'available'),
('Live Goat - Female', 2, 180000, 8, 'Healthy female goat, good for breeding', 'available'),
('Live Goat - Male', 2, 220000, 6, 'Strong male goat for meat', 'available'),
('Fresh Maize (100kg bag)', 3, 150000, 20, 'High-quality maize from our farm', 'available'),
('Dried Beans (50kg bag)', 4, 120000, 15, 'Nutritious beans, carefully dried', 'available'),
('Fresh Eggs - Tray (30 eggs)', 5, 15000, 100, 'Fresh eggs collected daily', 'available'),
('Fresh Cassava (50kg bag)', 6, 80000, 25, 'Freshly harvested cassava', 'available'),
('Pork Meat (1kg)', 1, 18000, 30, 'Fresh pork, cut to order', 'limited'),
('Goat Meat (1kg)', 2, 20000, 25, 'Fresh goat meat, tender and tasty', 'available');