-- Run once on an existing database. New seed/export files already include this column.
ALTER TABLE users ADD COLUMN avatar VARCHAR(255) NULL AFTER address;
