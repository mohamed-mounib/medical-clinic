# Setup Guide - Medical Clinic Backend

## Quick Start

### Step 1: Database Setup

1. **Create Database:**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Click "New" to create a database
   - Name it: `medical_clinic`
   - Or run the SQL file: Import `database_schema.sql` in phpMyAdmin

2. **Verify Tables:**
   - You should see two tables: `appointments` and `authentication`
   - Default admin user is already created (username: `admin`, password: `admin123`)

### Step 2: Configure Database Connection

Edit `connection.php` and update these lines if needed:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'medical_clinic');
define('DB_USER', 'root');
define('DB_PASS', '1234');  // Change to your MySQL password
```

### Step 3: Test the System

1. **Test Appointment Submission:**
   - Go to your React app: http://localhost:5173/appointment
   - Fill out the form and submit
   - Check if data appears in the database

2. **Test Admin Login:**
   - Navigate to: http://localhost/my-react-app/back-end/login.php
   - Login with: `admin` / `admin123`
   - You should see the dashboard

3. **Test Appointment Management:**
   - From dashboard, click "Manage Appointments"
   - Test all actions: Details, Edit, Delete, Download

## File Structure

```
back-end/
├── connection.php              # Database connection
├── database_schema.sql          # Database schema
├── login.php                   # Login/Registration page
├── check_session.php           # Session helper
├── logout.php                  # Logout handler
├── dashboard.php               # Admin dashboard
├── process_appointment.php     # Process form submissions
├── manage_appointments.php     # List all appointments
├── appointment_details.php     # View appointment details
├── edit_appointment.php        # Edit appointment form
├── delete_appointment.php      # Delete appointment
├── download_file.php           # Download medical files
└── README.md                   # Documentation
```

## Features Checklist

- ✅ Database connection with PDO
- ✅ Appointment form processing
- ✅ Input validation and sanitization
- ✅ File upload (PDF, JPG, PNG)
- ✅ SQL injection protection
- ✅ XSS protection
- ✅ User authentication
- ✅ Password hashing
- ✅ Session management
- ✅ Admin dashboard
- ✅ Manage appointments (CRUD)
- ✅ DataTables integration
- ✅ Email notifications (optional)

## Default Credentials

- **Username:** admin
- **Password:** admin123

## Troubleshooting

### Issue: "Database connection failed"
**Solution:** Check database credentials in `connection.php` and ensure MySQL is running.

### Issue: "File upload failed"
**Solution:** 
- Check if `uploads/` directory exists in parent folder
- Ensure web server has write permissions
- Check PHP upload settings in php.ini

### Issue: "Email not sending"
**Solution:** 
- Configure PHP mail() function
- For local development, emails may not send (this is normal)
- For production, use SMTP or mail service

### Issue: "Session not working"
**Solution:**
- Ensure PHP sessions are enabled
- Check session.save_path in php.ini
- Clear browser cookies

### Issue: CORS errors in React app
**Solution:**
- Update CORS headers in `process_appointment.php` if React runs on different port
- Current setting: `http://localhost:5173` (Vite default)

## Security Notes

1. **Change default admin password** after first login
2. **Use strong passwords** for production
3. **Move uploads folder** outside web root in production
4. **Enable HTTPS** in production
5. **Regular database backups** recommended

## Next Steps

1. Customize the admin dashboard design
2. Add more validation rules
3. Implement email templates
4. Add appointment status management
5. Add user roles and permissions

