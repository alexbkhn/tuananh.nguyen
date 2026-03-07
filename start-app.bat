@echo off
REM Script khởi động ứng dụng Laravel
REM Bước 1: Kiểm tra MySQL
echo Dang kiem tra MySQL...
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] MySQL dang chay
) else (
    echo [WARNING] MySQL chua chay, vui long khoi dong XAMPP Control Panel
    echo.
)

REM Bước 2: Khởi động development server
echo.
echo Khoi dong Laravel development server...
echo Server se chay tai: http://localhost:8000
echo.
cd /d "c:\xampp\htdocs\tuananh.nguyen"
C:\xampp\php\php.exe artisan serve

pause
