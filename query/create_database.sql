-- Create the database (your prof can rename this if needed)
CREATE DATABASE IF NOT EXISTS user_system;
USE user_system;

-- Create the customers table
CREATE TABLE IF NOT EXISTS customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  gender VARCHAR(20),
  location VARCHAR(100),
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);