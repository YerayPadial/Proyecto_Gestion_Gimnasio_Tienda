-- Drop the existing table
DROP TABLE IF EXISTS users;

-- Create the table again
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

-- Insert some example users
INSERT INTO users (username, password, email) VALUES ('user1', 'password1', 'user1@example.com');
INSERT INTO users (username, password, email) VALUES ('user2', 'password2', 'user2@example.com');
INSERT INTO users (username, password, email) VALUES ('user3', 'password3', 'user3@example.com');
INSERT INTO users (username, password, email) VALUES ('user4', 'password4', 'user4@example.com');