# Lester Dann Lopez — PHP/MySQL Login & Registration Website

This is a student web application project developed for the Information Management subject. It demonstrates a complete user login and registration system using PHP, MySQL, Bootstrap, and session management.

## 📌 Features

* User registration with password encryption (password\_hash)
* Login system with session-based authentication
* Secure logout functionality
* Responsive front-end design using Bootstrap and a customized CSS layout (styles.css)
* Protected home page that greets the logged-in user
* Database-driven user management (MySQL)

## 🛠 Technologies Used

* PHP 8.x
* MySQL (via XAMPP on macOS)
* HTML5, CSS3
* Bootstrap 5.3
* Visual Studio Code (VS Code)
* DBeaver for database management

## 🧪 How to Run the Project

1. Start XAMPP and make sure Apache and MySQL are running.
2. Place the /lester\_site/ folder in:
   /Applications/XAMPP/htdocs/
3. Open your browser and go to:
   [http://localhost/lester\_site/](http://localhost/lester_site/)
4. Create the database using DBeaver or phpMyAdmin:

   * Database name: user\_system
   * Table: users

   ```sql
   CREATE TABLE users (
     id INT AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(50) UNIQUE NOT NULL,
     password VARCHAR(255) NOT NULL
   );
   ```
5. Edit config.php to match your MySQL credentials if needed.
6. Register a new user and test login/logout flow.

## 📸 Screenshot

Include a screenshot of the home page, login, and register pages here (optional).

## 🧑‍🎓 Author

Lester Dann Lopez
Information Management — Student Project
May 2025

---