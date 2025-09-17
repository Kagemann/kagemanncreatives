@echo off
echo ========================================
echo Kagemann Creatives - Docker Setup
echo ========================================
echo.

REM Check if Docker is running
docker version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Docker is not running or not installed
    echo.
    echo Please:
    echo 1. Install Docker Desktop from https://docker.com
    echo 2. Start Docker Desktop
    echo 3. Run this script again
    echo.
    pause
    exit /b 1
)

echo ✅ Docker is running!
echo.

REM Create wp-content directory if it doesn't exist
if not exist "wp-content" (
    mkdir wp-content
    echo Created wp-content directory
)

REM Copy theme to wp-content
echo 📁 Copying theme files...
if not exist "wp-content\themes" (
    mkdir wp-content\themes
)

xcopy "bureau-site\wp-content\themes\kagemann-bureau" "wp-content\themes\kagemann-bureau\" /E /I /Y

echo.
echo 🐳 Starting Docker containers...
echo.

REM Start Docker Compose
docker-compose up -d

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ✅ Docker containers started successfully!
    echo.
    echo 🌐 Your WordPress site is available at:
    echo    http://localhost:8080
    echo.
    echo 🗄️  phpMyAdmin is available at:
    echo    http://localhost:8081
    echo.
    echo 📋 Default credentials:
    echo    Username: admin
    echo    Password: admin
    echo.
    echo 🛑 To stop the containers, run:
    echo    docker-compose down
    echo.
    echo 📖 For more information, see LOCAL-SETUP.md
    echo.
) else (
    echo ❌ Error starting Docker containers
    echo Check the error messages above
)

pause
