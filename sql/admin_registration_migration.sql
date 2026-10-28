-- Run once on existing placement_db installations before using admin/register.php.
USE placement_db;
ALTER TABLE admin ADD COLUMN email VARCHAR(100) NULL AFTER username;
ALTER TABLE admin ADD UNIQUE KEY uq_admin_email (email);
