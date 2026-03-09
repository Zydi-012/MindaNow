-- Fix admin password
-- This updates the password to a proper bcrypt hash
-- Password will be: admin123

UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE username = 'admin';

-- Verify the update
SELECT id, username, email, role, 
       SUBSTRING(password, 1, 20) as password_preview 
FROM users 
WHERE username = 'admin';
