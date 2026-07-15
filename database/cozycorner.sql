-- =====================================================
-- CozyCorner Database Schema
-- -----------------------------------------------------
-- How to use:
-- 1. Open phpMyAdmin (or run this file with the mysql/mariadb CLI).
-- 2. Create a database called "cozycorner" (or just run this
--    whole file - it creates the database for you too).
-- 3. Import / run this file.
-- 4. Update config.php with your DB username & password if needed.
-- =====================================================

CREATE DATABASE IF NOT EXISTS cozycorner
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE cozycorner;

-- -----------------------------------------------------
-- Table: users
-- Stores every registered member of CozyCorner.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: blogs
-- Cozy blog posts written by members.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    image VARCHAR(500) DEFAULT NULL,
    content TEXT NOT NULL,
    author VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: comments
-- Comments left on a blog post. Linked to blogs.id.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    username VARCHAR(50) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comments_blog
        FOREIGN KEY (blog_id) REFERENCES blogs(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: letters
-- "The Letter I Never Sent" - anonymous letter wall.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS letters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    to_user VARCHAR(100) DEFAULT NULL,
    from_user VARCHAR(100) DEFAULT NULL,
    message TEXT NOT NULL,
    reply TEXT DEFAULT NULL,
    reply_from VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: feedback
-- Visitor feedback (used to be a plain text file - now
-- stored safely in the database instead).
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Sample data so the site isn't empty on first run.
-- (Safe to delete any time from phpMyAdmin.)
-- -----------------------------------------------------
INSERT INTO blogs (title, image, content, author) VALUES
('Why I Love Slow Mornings',
 'https://i.pinimg.com/736x/af/55/08/af550839e3cf842ae4d13e12769a36cf.jpg',
 'There is something magical about a slow morning - warm light through the curtains, a cup of tea, and no rush at all. I have started waking up twenty minutes earlier just to sit with my thoughts before the day begins. It has changed how I feel for the rest of the day completely.',
 'CozyTeam'),
('My Favourite Cozy Reads',
 'https://i.pinimg.com/736x/84/dc/de/84dcde99553b85e246ee2c71f49c39fc.jpg',
 'A good book and a blanket are basically the same thing to me. Here are a few cozy reads that made my winter so much warmer this year, perfect for rainy afternoons with a hot drink in hand.',
 'CozyTeam');

INSERT INTO letters (to_user, from_user, message) VALUES
('My Future Self', 'Anonymous', 'I hope by the time you read this, you have learned to be gentle with yourself. You are doing better than you think.');
