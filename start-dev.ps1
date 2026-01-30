# Laravel Development Starter Script
# This script starts both the Laravel server and the queue worker

Write-Host "Starting Laravel Development Environment..." -ForegroundColor Green
Write-Host ""

# Start the queue worker in a new window with a clear title
Write-Host "Starting Queue Worker..." -ForegroundColor Cyan
$queueWorkerTitle = "Laravel Queue Worker - DO NOT CLOSE"
Start-Process powershell -ArgumentList "-NoExit", "-Command", "`$Host.UI.RawUI.WindowTitle='$queueWorkerTitle'; cd '$PWD'; Write-Host 'Queue Worker Started - Processing OTP Emails' -ForegroundColor Green; Write-Host 'Keep this window open for OTP emails to work!' -ForegroundColor Yellow; Write-Host ''; php artisan queue:work --tries=3 --timeout=90"

# Wait a moment for the queue worker to start
Start-Sleep -Seconds 3

# Start the Laravel server in this window
Write-Host "Starting Laravel Server..." -ForegroundColor Cyan
Write-Host ""
Write-Host "==============================================" -ForegroundColor Yellow
Write-Host "  Laravel Server & Queue Worker Running! " -ForegroundColor Green
Write-Host "  Server: http://localhost:8000" -ForegroundColor White
Write-Host "  Queue Worker: Running in separate window" -ForegroundColor White
Write-Host "" -ForegroundColor White
Write-Host "  ⚠️  IMPORTANT: Keep the 'Queue Worker'" -ForegroundColor Red
Write-Host "     window open for OTP emails to work!" -ForegroundColor Red
Write-Host "==============================================" -ForegroundColor Yellow
Write-Host ""

php artisan serve
