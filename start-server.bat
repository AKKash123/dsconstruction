@echo off
title DS Construction Web Server
echo ========================================================
echo   DS CONSTRUCTION - LUXURY BUILDERS & ARCHITECTS
echo ========================================================
echo   Local Web Server starting on: http://localhost:8000
echo.
echo   [Public Website]: http://localhost:8000
echo   [Admin Panel]:    http://localhost:8000/admin/login.php
echo   [Default Login]:  admin / admin123
echo.
echo   If you use XAMPP Apache, it is also available at:
echo   http://localhost/ds-construction
echo ========================================================
start "" http://localhost:8000
"C:\xampp\php\php.exe" -S localhost:8000
