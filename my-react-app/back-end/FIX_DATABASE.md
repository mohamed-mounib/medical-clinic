# Fix Database Connection Error

## The Problem
The error shows: `Access denied for user 'root'@'localhost' (using password: YES)`

This means the password in `connection.php` is incorrect.

## Solution: Update Database Password

### Step 1: Find Your MySQL Password

**Option A: Check if you have a password set**
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Try to login:
   - If it works **without password** → Your password is empty
   - If it asks for password → Use that password

**Option B: If you don't remember the password**
1. Open XAMPP Control Panel
2. Click **Config** next to MySQL
3. Select **my.ini**
4. Look for password settings
5. Or reset MySQL password (see below)

### Step 2: Update connection.php

Edit `C:\xampp\htdocs\my-react-app\back-end\connection.php`

**If your MySQL has NO password (empty):**
```php
define('DB_PASS', '');
```

**If your MySQL has a password:**
```php
define('DB_PASS', 'your_actual_password');
```

Common passwords people use:
- Empty: `''`
- `root`
- `password`
- `1234`
- `admin`

### Step 3: Reset MySQL Password (If Needed)

If you can't remember the password:

1. **Stop MySQL** in XAMPP
2. Open Command Prompt as Administrator
3. Navigate to: `cd C:\xampp\mysql\bin`
4. Run: `mysqld --skip-grant-tables`
5. Open new Command Prompt
6. Run: `mysql -u root`
7. Run these SQL commands:
```sql
USE mysql;
UPDATE user SET password=PASSWORD('') WHERE User='root';
FLUSH PRIVILEGES;
EXIT;
```
8. Restart MySQL in XAMPP
9. Update `connection.php` with empty password: `define('DB_PASS', '');`

### Step 4: Verify Database Exists

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Check if database `medical_clinic` exists
3. If NOT, create it:
   - Click "New" in left sidebar
   - Database name: `medical_clinic`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"
4. Import the schema:
   - Select `medical_clinic` database
   - Click "Import" tab
   - Choose file: `database_schema.sql`
   - Click "Go"

### Step 5: Test Connection

After updating `connection.php`, test:
```
http://localhost/my-react-app/back-end/test_connection.php
```

Should show: `{"status":"success",...}`

## Quick Fix (Most Common)

Most XAMPP installations have **NO password** for root user.

Simply change line 6 in `connection.php`:
```php
define('DB_PASS', '');  // Empty password
```

Save and test again!

