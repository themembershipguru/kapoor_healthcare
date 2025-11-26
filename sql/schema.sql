CREATE DATABASE IF NOT EXISTS kapoor_healthcare;
USE kapoor_healthcare;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','doctor','patient') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE doctors (
  doctor_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  specialization VARCHAR(100),
  qualification VARCHAR(100),
  experience VARCHAR(50),
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE patients (
  patient_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  age INT,
  gender VARCHAR(10),
  contact VARCHAR(15),
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE appointments (
  appointment_id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  status ENUM('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
  FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
  FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);

CREATE TABLE visits (
  visit_id INT AUTO_INCREMENT PRIMARY KEY,
  appointment_id INT NOT NULL,
  symptoms TEXT,
  diagnosis TEXT,
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE CASCADE
);

CREATE TABLE prescriptions (
  prescription_id INT AUTO_INCREMENT PRIMARY KEY,
  visit_id INT NOT NULL,
  medicine_name VARCHAR(200) NOT NULL,
  dosage VARCHAR(50),
  duration VARCHAR(50),
  frequency VARCHAR(50),
  FOREIGN KEY (visit_id) REFERENCES visits(visit_id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password, role)
VALUES (
  'Admin User',
  'admin@kapoorhealthcare.com',
  '$2y$12$y2jNgm.YbgszwZ0m6fcu6u0eLkyVyRyUgDm.lIN5yB7inIKeoBvE2', -- hash of admin123
  'admin'
);

