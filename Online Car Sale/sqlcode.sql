-- Create the database
CREATE DATABASE IF NOT EXISTS car_sale;
USE car_sale;

-- Create sellers table
CREATE TABLE sellers (
    seller_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255),
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create cars table
CREATE TABLE cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    location VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES sellers(seller_id)
);

-- Insert some sample data
INSERT INTO sellers (name, address, phone, email, username, password) 
VALUES 
('John Doe', '123 Main St, Kathmandu', '9876543210', 'john@example.com', 'johndoe', '$2y$10$N7BmZq3E9yW5X1l6vQwZ.e5vJkU7m8Yn9Jd7r6s5t4u3v2w1x0yz'),
('Jane Smith', '456 Oak Ave, Pokhara', '9876543211', 'jane@example.com', 'janesmith', '$2y$10$N7BmZq3E9yW5X1l6vQwZ.e5vJkU7m8Yn9Jd7r6s5t4u3v2w1x0yz');

INSERT INTO cars (seller_id, make, model, year, location, price)
VALUES
(1, 'Tesla', 'Model S', 2022, 'Kathmandu', 129990.00),
(1, 'BMW', 'M8 Competition', 2021, 'Kathmandu', 133995.00),
(2, 'Toyota', 'Land Cruiser', 2023, 'Pokhara', 87445.00);