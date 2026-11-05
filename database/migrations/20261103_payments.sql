-- Run once against the existing database before using the new payment flow.
-- Existing orders remain COD; completed orders are recorded as collected.
ALTER TABLE orders
    ADD COLUMN payment_method ENUM('cod','bank_transfer') NOT NULL DEFAULT 'cod',
    ADD COLUMN payment_status ENUM('unpaid','reported','paid','refund_pending','refunded') NOT NULL DEFAULT 'unpaid',
    ADD COLUMN payment_reference VARCHAR(40) NULL UNIQUE,
    ADD COLUMN payment_bank_bin VARCHAR(6) NULL,
    ADD COLUMN payment_bank_name VARCHAR(100) NULL,
    ADD COLUMN payment_account_number VARCHAR(34) NULL,
    ADD COLUMN payment_account_name VARCHAR(100) NULL,
    ADD COLUMN payment_reported_at DATETIME NULL,
    ADD COLUMN paid_at DATETIME NULL,
    ADD COLUMN payment_confirmed_by INT UNSIGNED NULL,
    ADD COLUMN refunded_at DATETIME NULL,
    ADD COLUMN refund_confirmed_by INT UNSIGNED NULL;
UPDATE orders SET payment_status = 'paid', paid_at = created_at WHERE status = 'completed';
