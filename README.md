# 🎓 Campus Placement Record Management System

A full-stack web application designed for colleges and universities to streamline campus recruitment drives, student applications, ATS resume evaluation, and administrator placement management.

---

## 🌟 Key Features

### 👨‍🎓 Student Portal
- **Student Authentication**: Secure registration and login.
- **Profile Management**: Branch, CGPA, semester, and technical skills tracking.
- **Drive Discovery & Applications**: Browse upcoming placement drives and apply with eligibility verification.
- **Application Tracking**: Real-time status tracking (Pending, Shortlisted, Selected, Rejected).
- **🤖 ATS Resume Studio**: Upload PDF or DOCX resumes for instant ATS keyword matching and actionable structure feedback.

### 🛡️ Admin Portal
- **Placement Dashboard**: Real-time metrics on total students, drives, and applications.
- **Drive Management**: Create, update, and manage upcoming/ongoing recruitment drives.
- **Applicant Tracking**: View applicants per drive with skill filters, GPA sorting, and one-click status updates.
- **Export Data**: One-click applicant data export to CSV/Excel.
- **Admin Management**: Create and manage multiple placement officer accounts.

---

## 🛠️ Tech Stack
- **Backend**: PHP 8.x
- **Database**: MySQL / MariaDB
- **Frontend**: Responsive HTML5, CSS3 (Modern Dark SaaS Theme), Vanilla JavaScript
- **Deployment**: Compatible with XAMPP, Apache, Docker, and Cloud Hosting (InfinityFree, Railway, Render, cPanel)

---

## 🚀 Quick Start (Local Setup with XAMPP)

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/safinbhoraniya786/placement-system.git
   ```
2. **Move to Web Server**:
   Move the folder to your web server root (e.g. `C:\xampp\htdocs\placement_system`).

3. **Import Database**:
   - Start **Apache** and **MySQL** in XAMPP.
   - Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
   - Create a new database named `placement_db`.
   - Import `sql/placement_db_export.sql`.

4. **Run the Application**:
   - Open your browser and navigate to:
     ```
     http://localhost/placement_system/index.php
     ```

---

## 🔑 Default Credentials

- **Admin Portal**:
  - **URL**: `admin/login.php`
  - **Username**: `admin`
  - **Password**: `admin123`

---

## 🐳 Docker Deployment

A `Dockerfile` is included for containerized hosting:
```bash
docker build -t placement-system .
docker run -p 8080:80 placement-system
```

---

## 📄 License
This project is open source and available under the [MIT License](LICENSE).
