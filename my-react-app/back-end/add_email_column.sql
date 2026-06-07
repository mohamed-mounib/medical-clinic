-- Add email column to authentication table if it doesn't exist
USE medical_clinic;

ALTER TABLE authentication 
ADD COLUMN IF NOT EXISTS email VARCHAR(255) NOT NULL DEFAULT '' AFTER password;

-- Update existing admin user if email is empty
UPDATE authentication 
SET email = 'admin@clinic.com' 
WHERE username = 'admin' AND (email = '' OR email IS NULL);

