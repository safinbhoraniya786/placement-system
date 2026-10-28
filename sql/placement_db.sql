-- ============================================================
-- Placement Record Management System — Database Setup
-- Import this file in phpMyAdmin: Import tab > Choose file > Go
-- ============================================================

CREATE DATABASE IF NOT EXISTS placement_db;
USE placement_db;

-- ---------- STUDENT ----------
CREATE TABLE students (
    student_id   INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    email        VARCHAR(100) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,
    department   VARCHAR(50),
    branch       VARCHAR(80),
    semester     VARCHAR(10),
    cgpa         DECIMAL(3,2),
    skills       TEXT,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------- ADMIN ----------
CREATE TABLE admin (
    admin_id     INT AUTO_INCREMENT PRIMARY KEY,
    username     VARCHAR(50) NOT NULL UNIQUE,
    email        VARCHAR(100) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL
);

-- ---------- COMPANY ----------
CREATE TABLE company (
    company_id   INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    package      VARCHAR(50),
    description  TEXT
);

-- ---------- DRIVE (FK -> company) ----------
CREATE TABLE drive (
    drive_id     INT AUTO_INCREMENT PRIMARY KEY,
    company_id   INT NOT NULL,
    drive_date   DATE NOT NULL,
    eligibility  VARCHAR(255),
    status       VARCHAR(20) DEFAULT 'upcoming',
    FOREIGN KEY (company_id) REFERENCES company(company_id) ON DELETE CASCADE
);

-- ---------- APPLICATION (FK -> students, FK -> drive) ----------
CREATE TABLE application (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id     INT NOT NULL,
    drive_id       INT NOT NULL,
    applied_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status         VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (drive_id)   REFERENCES drive(drive_id) ON DELETE CASCADE
);

-- ---------- Seed one Admin account for testing ----------
-- Username: admin   Password: admin123
INSERT INTO admin (username, email, password)
VALUES ('admin', 'admin@example.com', '$2b$12$l88asegxQL/GG9tF89mfNuXhtezSDsh.QATpPOqxxfTcwVP6WRdDS');

-- ---------- Seed a sample company + drive so the homepage isn't empty ----------
INSERT INTO company (name, package, description)
VALUES ('TechNova Pvt Ltd', '6 LPA', 'Software development and IT services company.');

INSERT INTO drive (company_id, drive_date, eligibility, status)
VALUES (1, '2026-09-15', 'CGPA 7.0+, no active backlog', 'upcoming');
