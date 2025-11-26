@echo off
REM Start PHP built-in server for Kapoor Healthcare (Windows)
echo Starting Kapoor Healthcare server...
echo Access it at: http://localhost:8000
echo Press Ctrl+C to stop the server
echo.

cd /d "%~dp0"
php -S localhost:8000

