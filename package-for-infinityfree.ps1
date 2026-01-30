# InfinityFree Deployment Package Script
# Run this after composer install completes

Write-Host "================================" -ForegroundColor Green
Write-Host "InfinityFree Deployment Packager" -ForegroundColor Green
Write-Host "================================`n" -ForegroundColor Green

# Copy Laravel core folders to deployment/htdocs/laravel
Write-Host "Copying Laravel files..." -ForegroundColor Yellow

$folders = @("app", "bootstrap", "config", "database", "resources", "routes", "storage", "vendor")

foreach ($folder in $folders) {
    Write-Host "  Copying $folder..." -ForegroundColor Cyan
    Copy-Item -Path $folder -Destination "deployment\htdocs\laravel\$folder" -Recurse -Force
}

# Copy artisan
Copy-Item -Path "artisan" -Destination "deployment\htdocs\laravel\artisan" -Force

# Copy public assets (css, js, images) to htdocs root
Write-Host "`nCopying public assets..." -ForegroundColor Yellow

if (Test-Path "public\css") {
    Copy-Item -Path "public\css" -Destination "deployment\htdocs\css" -Recurse -Force
    Write-Host "  Copied CSS" -ForegroundColor Cyan
}

if (Test-Path "public\js") {
    Copy-Item -Path "public\js" -Destination "deployment\htdocs\js" -Recurse -Force
    Write-Host "  Copied JS" -ForegroundColor Cyan
}

if (Test-Path "public\images") {
    Copy-Item -Path "public\images" -Destination "deployment\htdocs\images" -Recurse -Force
    Write-Host "  Copied Images" -ForegroundColor Cyan
}

# Create .env template for InfinityFree
Write-Host "`nCreating .env template..." -ForegroundColor Yellow

$envContent = @"
APP_NAME=InvoiceDesk
APP_ENV=production
APP_KEY=base64:CpWnKXCblrhYua+gjPimLucR4fayNZkIEDUNpcekt0U=
APP_DEBUG=false
APP_URL=https://YOUR-SITE.infinityfreeapp.com

# REPLACE WITH YOUR INFINITYFREE MYSQL DETAILS
DB_CONNECTION=mysql
DB_HOST=sqlXXX.infinityfree.com
DB_PORT=3306
DB_DATABASE=epiz_XXXXXXXX_dbname
DB_USERNAME=epiz_XXXXXXXX
DB_PASSWORD=your_db_password

SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync

# Gmail SMTP (Already Configured)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=bhargavpatel0580@gmail.com
MAIL_PASSWORD=ktboemwbvkduwbci
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="bhargavpatel0580@gmail.com"
MAIL_FROM_NAME="InvoiceDesk"
"@

$envContent | Out-File -FilePath "deployment\htdocs\laravel\.env.example" -Encoding UTF8

Write-Host "`n================================" -ForegroundColor Green
Write-Host "Deployment package ready!" -ForegroundColor Green
Write-Host "================================`n" -ForegroundColor Green

Write-Host "Location: d:\biling\deployment\htdocs\" -ForegroundColor White
Write-Host "`nNext Steps:" -ForegroundColor Yellow
Write-Host "1. Sign up at infinityfree.net" -ForegroundColor White
Write-Host "2. Get your FTP credentials" -ForegroundColor White
Write-Host "3. Upload htdocs folder contents to InfinityFree" -ForegroundColor White
Write-Host "4. Rename .env.example to .env and update DB details" -ForegroundColor White
Write-Host "5. Import your database via phpMyAdmin" -ForegroundColor White
Write-Host "`nSee DEPLOYMENT_GUIDE.md for detailed instructions`n" -ForegroundColor Cyan
