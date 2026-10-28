-- Run once on existing placement_db installations before enabling CGPA/branch eligibility.
USE placement_db;
ALTER TABLE students ADD COLUMN branch VARCHAR(80) NULL AFTER department;
ALTER TABLE students ADD COLUMN cgpa DECIMAL(3,2) NULL AFTER semester;
