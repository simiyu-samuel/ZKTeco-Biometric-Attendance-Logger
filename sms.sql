CREATE DATABASE attendance_system;

USE attendance_system;

CREATE TABLE attendance_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    action VARCHAR(10) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sms_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
