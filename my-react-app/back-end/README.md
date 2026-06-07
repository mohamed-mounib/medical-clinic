# Medical Clinic Backend System

This directory contains all the PHP backend files for the Medical Clinic appointment management system.

## Setup Instructions

### 1. Database Setup

1. Open phpMyAdmin or your MySQL client
2. Import the database schema:
   - Run the SQL commands from `database_schema.sql`
   - Or execute: `mysql -u root -p medical_clinic < database_schema.sql`

3. Default Admin Credentials:
   - Username: `admin`
   - Password: `admin123`

### 2. Configuration

Update `connection.php` with your database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'medical_clinic');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
```

### 3. File Uploads Directory

The system will automatically create an `uploads/` directory in the parent folder for medical files. Make sure the web server has write permissions.

### 4. Access the Admin Panel

1. Start your web server (XAMPP, WAMP, etc.)
2. Navigate to: `http://localhost/my-react-app/back-end/login.php`
3. Login with admin credentials or create a new account

## File Structure

- `connection.php` - Database connection using PDO
- `database_schema.sql` - Database schema and tables
- `login.php` - User login and registration page
- `check_session.php` - Session management helper
- `logout.php` - Logout handler
- `dashboard.php` - Admin dashboard with statistics
- `process_appointment.php` - Processes appointment form submissions
- `manage_appointments.php` - List all appointments with DataTables
- `appointment_details.php` - View full appointment details
- `edit_appointment.php` - Edit appointment form
- `delete_appointment.php` - Delete appointment handler
- `download_file.php` - Download medical files

## Features Implemented

✅ Database connection with PDO
✅ Appointment form processing with validation
✅ File upload (PDF, JPG, PNG) with validation
✅ User authentication system with password hashing
✅ Admin dashboard with statistics
✅ Manage appointments with full CRUD operations
✅ DataTables integration (search, pagination, sorting)
✅ Email notification (optional - requires mail server configuration)
✅ Session management
✅ SQL injection and XSS protection

## Notes

- Email notifications require a properly configured mail server (PHP mail() function)
- For production, consider using PHPMailer or similar library for better email delivery
- Make sure to update CORS headers in `process_appointment.php` if your React app runs on a different port
- The uploads directory should be outside the web root for better security in production

## Troubleshooting

1. **Database connection error**: Check database credentials in `connection.php`
2. **File upload fails**: Check directory permissions for `uploads/` folder
3. **Email not sending**: Configure PHP mail settings or use SMTP library
4. **Session issues**: Ensure PHP sessions are enabled and working

