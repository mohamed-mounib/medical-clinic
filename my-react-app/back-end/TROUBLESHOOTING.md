# Troubleshooting Connection Errors

## Error: "Failed to fetch" or "Connection Error"

This error occurs when the React app cannot connect to the PHP backend. Follow these steps:

### Step 1: Verify XAMPP is Running

1. Open XAMPP Control Panel
2. Make sure **Apache** is running (green status)
3. Make sure **MySQL** is running (green status)

### Step 2: Check the Project Path

The React app is trying to connect to:
```
http://localhost/my-react-app/back-end/process_appointment.php
```

This assumes your project is in:
```
C:\xampp\htdocs\my-react-app\
```

**If your project is in a different location** (like `C:\Users\LENOVO\Desktop\website\my-react-app\`), you have two options:

#### Option A: Copy Project to htdocs (Recommended)
1. Copy the entire `my-react-app` folder to `C:\xampp\htdocs\`
2. Your path should be: `C:\xampp\htdocs\my-react-app\`
3. Access backend at: `http://localhost/my-react-app/back-end/`

#### Option B: Configure XAMPP Virtual Host
1. Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Add this configuration:
```apache
<VirtualHost *:80>
    DocumentRoot "C:/Users/LENOVO/Desktop/website/my-react-app"
    ServerName localhost
    <Directory "C:/Users/LENOVO/Desktop/website/my-react-app">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
3. Restart Apache

### Step 3: Test Backend Connection

1. Open browser and go to:
   ```
   http://localhost/my-react-app/back-end/test_connection.php
   ```
2. You should see: `{"status":"success","message":"Backend is accessible!"}`
3. If you see an error, the path is wrong

### Step 4: Update React App URL (If Needed)

If your project is NOT in `htdocs/my-react-app/`, update the fetch URL in `Appointment.jsx`:

**Current:**
```javascript
'http://localhost/my-react-app/back-end/process_appointment.php'
```

**If project is directly in htdocs:**
```javascript
'http://localhost/back-end/process_appointment.php'
```

**If using a different folder name:**
```javascript
'http://localhost/YOUR_FOLDER_NAME/back-end/process_appointment.php'
```

### Step 5: Check Browser Console

1. Open browser Developer Tools (F12)
2. Go to Console tab
3. Submit the form
4. Look for detailed error messages
5. Check Network tab to see the actual request/response

### Step 6: Verify Database Connection

1. Check `connection.php` has correct database credentials
2. Make sure database `medical_clinic` exists
3. Test connection by accessing: `http://localhost/my-react-app/back-end/login.php`

### Common Issues

#### Issue: "404 Not Found"
**Solution:** The path is incorrect. Verify the project is in the correct location.

#### Issue: "CORS error"
**Solution:** Already fixed in `process_appointment.php`. Make sure you're using the updated file.

#### Issue: "500 Internal Server Error"
**Solution:** 
- Check PHP error logs in XAMPP
- Verify database connection in `connection.php`
- Make sure all PHP files are in the correct location

#### Issue: "Network Error"
**Solution:**
- Make sure Apache is running
- Check firewall isn't blocking localhost
- Try accessing the PHP file directly in browser

### Quick Test

1. **Test PHP is working:**
   ```
   http://localhost/my-react-app/back-end/test_connection.php
   ```

2. **Test login page:**
   ```
   http://localhost/my-react-app/back-end/login.php
   ```

3. **Test database:**
   - Try logging in with: `admin` / `admin123`
   - If login works, database is connected

### Still Having Issues?

1. Check XAMPP error logs: `C:\xampp\apache\logs\error.log`
2. Check PHP error logs: `C:\xampp\php\logs\php_error_log`
3. Verify file permissions (Windows usually handles this automatically)
4. Make sure no other application is using port 80

