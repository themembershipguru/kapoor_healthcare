# Kapoor Healthcare - Medical Management System

A web-based medical management system using PHP and MySQL for managing patients, doctors, appointments, visits and prescriptions.

BCA 5th Semester Minor Project

## Features

- Role-based login (Admin / Doctor / Patient)
- Admin:
  - Manage doctors
  - View patients
  - View all appointments
- Doctor:
  - See today's appointments
  - Add visit notes
  - Create simple prescriptions
- Patient:
  - Book appointments
  - View appointment history
- MySQL database with normalized schema
- AdminLTE dashboard UI

## Installation (Local – XAMPP)

1. Copy the `kapoor_healthcare` folder into your XAMPP `htdocs` directory.

2. Create a database `kapoor_healthcare` in phpMyAdmin.

3. Import `sql/schema.sql` into that database  
   **or** run `setup.php` in browser and fill DB details.

4. Update `config.php` if needed (DB password, BASE_URL).

5. Open in browser:

```
http://localhost/kapoor_healthcare/
```

6. Login as admin:

- Email: `admin@kapoorhealthcare.com`  
- Password: `admin123`

## Live Hosting (Plesk / cPanel)

1. Create a database & DB user.

2. Upload all files to your domain or subdomain (e.g. `care.kapoorhealthcare.com`).

3. Update `config.php` with live DB credentials and correct `BASE_URL`.

4. Import `sql/schema.sql` or run `setup.php` once (then delete it).

## Author

Neel Kapoor  
BCA 5th Semester - Minor Project

## ✅ How to Turn This into a ZIP & Repo

Create the folder kapoor_healthcare with this exact structure.

Paste each file's code as shown (Cursor will make this super fast).

Test locally:

- Create DB kapoor_healthcare
- Import sql/schema.sql
- Visit http://localhost/kapoor_healthcare

Once working, create ZIP from your OS:

- Windows: right-click folder → Send to → Compressed (zipped)
- Mac: right-click folder → Compress "kapoor_healthcare"

## Push to GitHub

1. Create a new repository on GitHub (don't initialize with README)

2. Run these commands in terminal:

```bash
cd kapoor_healthcare
git init
git add .
git commit -m "Initial commit - Kapoor Healthcare Medical Management System"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/kapoor_healthcare.git
git push -u origin main
```

Replace `YOUR_USERNAME` with your GitHub username.

