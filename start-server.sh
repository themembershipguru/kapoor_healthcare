#!/bin/bash
# Start PHP built-in server for Kapoor Healthcare
# This allows you to run the project from anywhere

echo "Starting Kapoor Healthcare server..."
echo "Access it at: http://localhost:8000"
echo "Press Ctrl+C to stop the server"
echo ""

cd "$(dirname "$0")"
php -S localhost:8000

