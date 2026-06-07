# Fix: Add Email Column to Authentication Table

## Quick Fix - Run This SQL in phpMyAdmin

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Select the `medical_clinic` database
3. Click the **SQL** tab
4. Copy and paste this SQL:

```sql
ALTER TABLE authentication 
ADD COLUMN email VARCHAR(255) NOT NULL DEFAULT '' AFTER password;

UPDATE authentication 
SET email = 'admin@clinic.com' 
WHERE username = 'admin';
```

5. Click **Go**

This will:
- Add the `email` column to the `authentication` table
- Set a default email for the existing admin user

## Alternative: If Column Already Exists Error

If you get an error saying the column already exists, just run:

```sql
UPDATE authentication 
SET email = 'admin@clinic.com' 
WHERE username = 'admin' AND (email = '' OR email IS NULL);
```

## After Running SQL

1. Refresh the login page
2. Try logging in again
3. It should work now!

