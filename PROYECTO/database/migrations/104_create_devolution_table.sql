CREATE TABLE devolution (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_name VARCHAR(100) NOT NULL,
    book VARCHAR(100) NOT NULL,
    time_since_borrow TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    borrow_until DATE NULL,
    recharge BOOLEAN DEFAULT FALSE,
    price_recharge DECIMAL(10,2) DEFAULT 0.00
);

// *correr con php run-migrations.php*