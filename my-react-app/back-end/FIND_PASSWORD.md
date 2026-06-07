# Find Your MySQL Password

## Quick Method: Check phpMyAdmin Config

1. **Open phpMyAdmin:** `http://localhost/phpmyadmin`
2. **Check the config file:**
   - The password phpMyAdmin uses is stored in: `C:\xampp\phpMyAdmin\config.inc.php`
   - Open that file in a text editor
   - Look for: `$cfg['Servers'][$i]['password']`
   - That's the password phpMyAdmin uses!

## Method 2: Test Different Passwords

Run this test script:
```
http://localhost/my-react-app/back-end/test_db_connection.php
```

It will test common passwords and tell you which one works.

## Method 3: Reset MySQL Password

If nothing works, reset MySQL to have no password:

1. **Stop MySQL** in XAMPP Control Panel
2. Open **Command Prompt as Administrator**
3. Navigate to MySQL bin:
   ```
   cd C:\xampp\mysql\bin
   ```
4. Start MySQL without password check:
   ```
   mysqld --skip-grant-tables --console
   ```
5. **Open a NEW Command Prompt** (keep the first one running)
6. Connect to MySQL:
   ```
   cd C:\xampp\mysql\bin
   mysql -u root
   ```
7. Run these commands:
   ```sql
   USE mysql;
   UPDATE user SET authentication_string='' WHERE User='root' AND Host='localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```
8. **Close both Command Prompts**
9. **Restart MySQL** in XAMPP
10. Update `connection.php`:
    ```php
    define('DB_PASS', '');
    ```

## Most Important: Edit the CORRECT File!

Make sure you're editing:
```
C:\xampp\htdocs\my-react-app\back-end\connection.php
```

NOT the Desktop version!

