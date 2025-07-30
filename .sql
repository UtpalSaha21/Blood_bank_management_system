-- Database: bloodbank
CREATE DATABASE IF NOT EXISTS bloodbank;
USE bloodbank;

-- Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    age INT,
    phone VARCHAR(20),
    address TEXT,
    blood_group VARCHAR(5),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    user_type ENUM('donor', 'recipient') NOT NULL
);

-- Table: donations
CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    blood_group VARCHAR(5),
    quantity INT,
    donation_date DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: blood_requests
CREATE TABLE blood_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    blood_group VARCHAR(5),
    quantity INT,
    request_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: blood_stock
CREATE TABLE blood_stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blood_group VARCHAR(5) UNIQUE NOT NULL,
    quantity INT NOT NULL DEFAULT 0
);

-- Table: requests
CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    request_type ENUM('donation', 'blood') NOT NULL,
    request_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
