# Admin Panel - InvoiceDesk

## Admin Login Credentials

**Email:** admin@invoicedesk.com  
**Password:** admin123

## Admin Panel Access

1. Go to the login page: `http://localhost:8000/login`
2. Click on the **"Admin"** button in the top right corner
3. Or directly access: `http://localhost:8000/admin/login`
4. Login with the credentials above

## Admin Features

### Dashboard
- View total number of registered companies
- See companies registered today
- See companies registered this week
- View all companies in a detailed table

### Company Management
- **View Company Details** - See complete information about any company
- **Delete Company** - Remove companies from the system (with confirmation)
- **Monitor Registration** - See when companies registered and last updated

### Data Displayed
- Company ID
- Company Name
- Email Address
- Phone Number
- GST Number
- Full Address
- Registration Date
- Last Updated Date

## Security Features

- Separate authentication guard for admin
- Admin passwords are automatically hashed
- Session-based authentication
- Protected routes with middleware
- Delete confirmation prompts

## Technical Details

### Routes
- `GET /admin/login` - Admin login page
- `POST /admin/login` - Handle admin login
- `GET /admin/dashboard` - Admin dashboard (protected)
- `GET /admin/company/{id}` - View company details (protected)
- `DELETE /admin/company/{id}` - Delete company (protected)
- `POST /admin/logout` - Admin logout

### Database
- Table: `admins`
- Fields: id, name, email, password, created_at, updated_at

### Models
- `App\Models\Admin` - Admin model with authentication

### Guards
- `web` - For company users
- `admin` - For admin users

## Notes

⚠️ **Important**: Change the default admin password in production!

To create additional admins or change the password, run:
```bash
php artisan tinker
```

Then execute:
```php
App\Models\Admin::create([
    'name' => 'Your Name',
    'email' => 'youremail@example.com',
    'password' => 'your-secure-password'
]);
```

The password will be automatically hashed.
