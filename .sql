-- Database: bloodbank
CREATE DATABASE IF NOT EXISTS bloodbank;
USE bloodbank;

-- Table: admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100)
);

-- Table: donor
CREATE TABLE donor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    age INT,
    phone VARCHAR(20),
    address TEXT,
    blood_group VARCHAR(5),
    email VARCHAR(100),
    password VARCHAR(255)
);

-- Table: recipient
CREATE TABLE recipient (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    age INT,
    phone VARCHAR(20),
    address TEXT,
    blood_group VARCHAR(5),
    email VARCHAR(100),
    password VARCHAR(255)
);

-- Table: blood_stock
CREATE TABLE blood_stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blood_group VARCHAR(5) NOT NULL,
    quantity INT NOT NULL DEFAULT 0
);

-- Table: donations
CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT,
    blood_group VARCHAR(5),
    quantity INT,
    donation_date DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (donor_id) REFERENCES donor(id) ON DELETE SET NULL
);

-- Table: blood_requests
CREATE TABLE blood_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_id INT,
    blood_group VARCHAR(5),
    quantity INT,
    request_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (recipient_id) REFERENCES recipient(id) ON DELETE SET NULL
);

-- Table: history_log
CREATE TABLE history_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('Donor', 'Recipient', 'Admin'),
    user_id INT,
    action VARCHAR(255),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);
