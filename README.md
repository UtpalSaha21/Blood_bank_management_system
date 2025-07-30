# 🩸 Blood Bank Management System

A complete **web-based blood bank management system** built with **PHP**, **MySQL**, and **XAMPP**. It streamlines blood donation and request processes for **donors**, **recipients**, and **administrators**.

---

## 🔧 Features

### 👥 User Roles
- **Admin** – Approves/rejects donations & requests, manages stock.
- **Donor** – Can donate blood and view donation history.
- **Recipient** – Can request blood and view request status.

### 🩸 Functional Highlights
- Donor and recipient registration/login
- Secure login with 'password_hash()'
- Blood donation form (auto-updates stock on approval)
- Blood request form (reduces stock on approval if available)
- Admin panel to manage all requests
- Real-time blood stock table
- History logs for donations and requests

---

## 🗃️ Database Schema

### Tables
- 'users': User registration (role: donor/recipient/admin)
- 'blood_requests': Tracks all blood donation and request submissions
- 'blood_stock': Maintains units available for each blood group

---

## 🖥️ Tech Stack

| Layer     | Technology   |
|-----------|--------------|
| Frontend  | HTML, CSS    |
| Backend   | PHP (Core)   |
| Database  | MySQL        |
| Server    | Apache (XAMPP) |

---

## 🚀 How to Run Locally

1. **Install XAMPP** (https://www.apachefriends.org/index.html)
2. Clone or download this project.
3. Move the folder to your 'htdocs' directory (usually 'C:/xampp/htdocs/').
4. Start **Apache** and **MySQL** from the XAMPP Control Panel.
5. Import the SQL file into **phpMyAdmin**:
   - Visit 'http://localhost/phpmyadmin'
   - Create a database named 'bloodbank'
   - Import the provided .sql file
6. Open your browser and visit:
[http://localhost/bloodbank/](http://localhost/bloodbank/)

## 🔐 Admin Login

Email - admin@bbms.com
Password - admin123

---

## 📂 Folder Structure

bloodbank/
│
├── index.php
├── login.php
├── register.php
├── logout.php
│
├── includes/
│   └── db.php                 # Database connection file
│
├── admin/
│   ├── dashboard.php          # Admin home page
│   ├── manage_requests.php    # Approve/Reject donor/recipient requests
│   ├── blood_stock.php        # Current blood stock table
│   ├── donation_history.php   # History of donations
│   ├── request_history.php    # History of requests
│   └── history.php            # Combined history (optional)
│
├── donor/
│   ├── dashboard.php          # Donor home page
│   └── donate_blood.php       # Donor form to donate blood
│
├── recipient/
│   ├── dashboard.php          # Recipient home page
│   └── request_blood.php      # Recipient form to request blood
│
├── Css/
│   ├── style.css              # Global styles (login, register)
│   ├── admin.css              # Admin dashboard & tables
│   └── user.css               # Donor/recipient dashboard style
│
├── sql/
│   └── bloodbank.sql          # SQL file to create all tables
│
└── README.md                  # GitHub project description


## 📌 Future Enhancements

- Email notification system
- Filter/search in admin panel
- Export reports to PDF/CSV
- Mobile responsive design

---

## 📄 License

This project is for educational use. You may modify and reuse it for academic or practice purposes.

 
