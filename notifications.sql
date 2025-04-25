-- SQL for notifications for both admin and user accounts

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_admin_id INT DEFAULT NULL,
    recipient_user_id INT DEFAULT NULL,
    message VARCHAR(255) NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_admin (recipient_admin_id),
    INDEX idx_user (recipient_user_id)
);

-- Usage:
-- For admin notifications, set recipient_admin_id and leave recipient_user_id NULL.
-- For user notifications, set recipient_user_id and leave recipient_admin_id NULL.
-- For system-wide notifications, set both recipient_admin_id and recipient_user_id to NULL (optional, if you want to support global notices).

-- You may want to add foreign key constraints if you have admin/user tables:
-- ALTER TABLE notifications ADD CONSTRAINT fk_admin FOREIGN KEY (recipient_admin_id) REFERENCES admins(id);
-- ALTER TABLE notifications ADD CONSTRAINT fk_user FOREIGN KEY (recipient_user_id) REFERENCES users(id);
