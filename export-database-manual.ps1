# Export Database Manually via phpMyAdmin

Write-Host "================================" -ForegroundColor Green
Write-Host "Database Export Instructions" -ForegroundColor Green
Write-Host "================================`n" -ForegroundColor Green

Write-Host "Since mysqldump may not be in your PATH, please export manually:`n" -ForegroundColor Yellow

Write-Host "METHOD 1: Using phpMyAdmin (Easiest)" -ForegroundColor Cyan
Write-Host "1. Open http://localhost/phpmyadmin" -ForegroundColor White
Write-Host "2. Click on 'InvoiceDesk' database" -ForegroundColor White
Write-Host "3. Click 'Export' tab" -ForegroundColor White
Write-Host "4. Click 'Go' (leave settings as default)" -ForegroundColor White
Write-Host "5. Save the .sql file to: d:\biling\deployment\database_export.sql`n" -ForegroundColor White

Write-Host "METHOD 2: Using HeidiSQL or MySQL Workbench" -ForegroundColor Cyan
Write-Host "- Export the 'InvoiceDesk' database" -ForegroundColor White
Write-Host "- Save to: d:\biling\deployment\database_export.sql`n" -ForegroundColor White

Write-Host "Then upload this file via InfinityFree phpMyAdmin`n" -ForegroundColor Green
