@echo off
TITLE Bot Notifikasi Garapan Background
:loop
"c:\xampp\php\php.exe" "c:\xampp\htdocs\herryfiersh\api\cron_bot.php"
timeout /t 60 /nobreak >nul
goto loop
