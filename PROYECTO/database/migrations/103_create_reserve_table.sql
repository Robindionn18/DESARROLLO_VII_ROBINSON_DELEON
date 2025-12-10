CREATE TABLE reserve (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_name VARCHAR(100) NOT NULL,
    book VARCHAR(100) NOT NULL,
    reserve_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reserve_until DATE NULL,
    reserve_on BOOLEAN DEFAULT TRUE
);