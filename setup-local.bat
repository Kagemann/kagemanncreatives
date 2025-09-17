@echo off
echo ========================================
echo Kagemann Creatives - Local Setup
echo ========================================
echo.

echo Setting up local WordPress environment...
echo.

REM Create wp-content directory structure
if not exist "wp-content\themes\kagemann-bureau" (
    mkdir "wp-content\themes\kagemann-bureau"
    echo Created wp-content directory structure
)

REM Copy theme files
echo Copying bureau theme files...
xcopy "bureau-site\wp-content\themes\kagemann-bureau\*" "wp-content\themes\kagemann-bureau\" /E /I /Y

if %ERRORLEVEL% EQU 0 (
    echo ✅ Theme files copied successfully!
) else (
    echo ❌ Error copying theme files
    pause
    exit /b 1
)

echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Choose your local WordPress setup:
echo    - Local by Flywheel (recommended)
echo    - XAMPP
echo    - Docker
echo.
echo 2. Copy the wp-content folder to your WordPress installation
echo.
echo 3. Activate the "Kagemann Creatives Bureau" theme
echo.
echo 4. Start customizing your content!
echo.
echo For detailed instructions, see LOCAL-SETUP.md
echo.
pause
