# Database Export for InfinityFree
# Export your local MySQL database to import on InfinityFree

Write-Host "================================" -ForegroundColor Green
Write-Host "Database Export Tool" -ForegroundColor Green
Write-Host "================================`n" -ForegroundColor Green

$dbName = "InvoiceDesk"
$dbUser = "root"
$dbPass = ""  # Empty for root by default
$outputFile = "deployment\database_export.sql"

Write-Host "Exporting database: $dbName" -ForegroundColor Yellow
Write-Host "Output file: $outputFile`n" -ForegroundColor Cyan

try {
    # Check if mysqldump is available
    $mysqldump = "mysqldump"
    
    if ($dbPass -eq "") {
        & $mysqldump -u $dbUser $dbName --result-file=$outputFile 2>&1
    } else {
        & $mysqldump -u $dbUser -p$dbPass $dbName --result-file=$outputFile 2>&1
    }
    
    if (Test-Path $outputFile) {
        Write-Host "✓ Database exported successfully!" -ForegroundColor Green
        Write-Host "`nYou can now:" -ForegroundColor Yellow
        Write-Host "1. Go to InfinityFree phpMyAdmin" -ForegroundColor White
        Write-Host "2. Select your database" -ForegroundColor White
        Write-Host "3. Click 'Import'" -ForegroundColor White
        Write-Host "4. Upload: $outputFile`n" -ForegroundColor White
    }
} catch {
    Write-Host "✗ Error exporting database" -ForegroundColor Red
    Write-Host "Please export manually via phpMyAdmin or HeidiSQL`n" -ForegroundColor Yellow
}
