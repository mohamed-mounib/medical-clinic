-- Add updated_at column to appointments table if it doesn't exist
USE medical_clinic;

ALTER TABLE appointments 
ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Verify the column was added
DESCRIBE appointments;
