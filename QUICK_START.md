# Quick Start Guide - Fixing 404 Error

## The Problem
Your project is on Desktop, but web servers typically serve from `htdocs` or similar directories.

## Solution Options

### Option 1: Use PHP Built-in Server (Easiest - Works from Desktop)

1. **On Mac/Linux:**
   ```bash
   cd ~/Desktop/kapoor_healthcare
   php -S localhost:8000
   ```

2. **On Windows:**
   ```cmd
   cd C:\Users\YourName\Desktop\kapoor_healthcare
   php -S localhost:8000
   ```

3. **Or use the provided script:**
   - Mac/Linux: Double-click `start-server.sh` or run `./start-server.sh`
   - Windows: Double-click `start-server.bat`

4. **Then access:** `http://localhost:8000`

### Option 2: Move to Web Server Directory

**For XAMPP (Mac):**
```bash
cp -r ~/Desktop/kapoor_healthcare /Applications/XAMPP/htdocs/
```
Then access: `http://localhost/kapoor_healthcare/`

**For XAMPP (Windows):**
```cmd
xcopy C:\Users\YourName\Desktop\kapoor_healthcare C:\xampp\htdocs\kapoor_healthcare\ /E /I
```
Then access: `http://localhost/kapoor_healthcare/`

**For MAMP (Mac):**
```bash
cp -r ~/Desktop/kapoor_healthcare /Applications/MAMP/htdocs/
```
Then access: `http://localhost:8888/kapoor_healthcare/`

### Option 3: Create Symbolic Link (Advanced)

**Mac/Linux:**
```bash
ln -s ~/Desktop/kapoor_healthcare /Applications/XAMPP/htdocs/kapoor_healthcare
```

**Windows (as Administrator):**
```cmd
mklink /D C:\xampp\htdocs\kapoor_healthcare C:\Users\YourName\Desktop\kapoor_healthcare
```

## Database Setup

Before accessing the site, make sure:

1. MySQL is running
2. Create database: `kapoor_healthcare`
3. Import `sql/schema.sql` OR run `setup.php` in browser

## Testing

1. Start the server (Option 1) or move files (Option 2)
2. Visit: `http://localhost:8000` (if using built-in server)
   OR `http://localhost/kapoor_healthcare/` (if using XAMPP)
3. Login with:
   - Email: `admin@kapoorhealthcare.com`
   - Password: `admin123`

## Troubleshooting

- **404 Error:** Make sure you're accessing the correct URL based on your setup
- **Database Error:** Check `config.php` - update DB_PASS if needed
- **PHP Not Found:** Make sure PHP is in your PATH or use full path to PHP executable

