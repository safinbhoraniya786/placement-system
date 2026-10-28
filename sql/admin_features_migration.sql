-- Run once on existing installations to enable skill filtering.
USE placement_db;
ALTER TABLE students ADD COLUMN skills TEXT NULL AFTER cgpa;
