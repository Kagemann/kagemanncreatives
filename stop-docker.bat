@echo off
echo ========================================
echo Kagemann Creatives - Stop Docker
echo ========================================
echo.

echo 🛑 Stopping Docker containers...
docker-compose down

if %ERRORLEVEL% EQU 0 (
    echo ✅ Docker containers stopped successfully!
    echo.
    echo 💡 To start again, run: start-docker.bat
) else (
    echo ❌ Error stopping Docker containers
)

echo.
pause
