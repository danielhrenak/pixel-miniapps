-- ShareLoop Database Schema
-- Created: 2026-02-15

-- Users Table
CREATE TABLE IF NOT EXISTS `shareloop_users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password_hash` VARCHAR(255) NULL,
  `first_name` VARCHAR(255) NULL,
  `last_name` VARCHAR(255) NULL,
  `verified` BOOLEAN NOT NULL DEFAULT FALSE,
  `active` BOOLEAN NOT NULL DEFAULT TRUE,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Verification Tokens
CREATE TABLE IF NOT EXISTS `shareloop_user_verifications` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `token_type` VARCHAR(50) NOT NULL DEFAULT 'email_verification',
  `expires_at` DATETIME NULL,
  `used` BOOLEAN NOT NULL DEFAULT FALSE,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  UNIQUE INDEX `idx_token` (`token`),
  CONSTRAINT `fk_user_verifications_user_id`
    FOREIGN KEY (`user_id`) REFERENCES `shareloop_users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Item Types (Book, Puzzle, Board Game, etc.)
CREATE TABLE IF NOT EXISTS `shareloop_item_types` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `icon` VARCHAR(255) NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idx_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Books Catalog
CREATE TABLE IF NOT EXISTS `shareloop_books` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `isbn` VARCHAR(20) NULL,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) NULL,
  `publisher` VARCHAR(255) NULL,
  `published_year` INT NULL,
  `description` TEXT NULL,
  `cover_image_url` VARCHAR(500) NULL,
  `pages` INT NULL,
  `language` VARCHAR(10) NOT NULL DEFAULT 'sk',
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idx_isbn` (`isbn`),
  INDEX `idx_title` (`title`),
  INDEX `idx_author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Locations (Shelves/Libraries)
CREATE TABLE IF NOT EXISTS `shareloop_user_locations` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `address` VARCHAR(500) NULL,
  `is_default` BOOLEAN NOT NULL DEFAULT FALSE,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  CONSTRAINT `fk_user_locations_user_id`
    FOREIGN KEY (`user_id`) REFERENCES `shareloop_users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Books (Individual book instances)
CREATE TABLE IF NOT EXISTS `shareloop_user_books` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `book_id` INT NOT NULL,
  `location_id` INT NULL,
  `item_type_id` INT NOT NULL DEFAULT 1,
  `condition` VARCHAR(50) NOT NULL DEFAULT 'good',
  `sharing_type` VARCHAR(50) NULL,
  `notes` TEXT NULL,
  `qr_code` VARCHAR(255) NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_book_id` (`book_id`),
  INDEX `idx_location_id` (`location_id`),
  CONSTRAINT `fk_user_books_user_id`
    FOREIGN KEY (`user_id`) REFERENCES `shareloop_users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_books_book_id`
    FOREIGN KEY (`book_id`) REFERENCES `shareloop_books` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_books_location_id`
    FOREIGN KEY (`location_id`) REFERENCES `shareloop_user_locations` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_books_item_type_id`
    FOREIGN KEY (`item_type_id`) REFERENCES `shareloop_item_types` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Book Borrowings History
CREATE TABLE IF NOT EXISTS `shareloop_book_borrowings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_book_id` INT NOT NULL,
  `borrower_id` INT NOT NULL,
  `borrowed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` DATETIME NULL,
  `returned_at` DATETIME NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'active',
  `notes` TEXT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_book_id` (`user_book_id`),
  INDEX `idx_borrower_id` (`borrower_id`),
  CONSTRAINT `fk_borrowings_user_book_id`
    FOREIGN KEY (`user_book_id`) REFERENCES `shareloop_user_books` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_borrowings_borrower_id`
    FOREIGN KEY (`borrower_id`) REFERENCES `shareloop_users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reading Lists
CREATE TABLE IF NOT EXISTS `shareloop_reading_lists` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `book_id` INT NOT NULL,
  `priority` INT NOT NULL DEFAULT 0,
  `status` VARCHAR(50) NOT NULL DEFAULT 'to_read',
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_book_id` (`book_id`),
  INDEX `idx_status` (`status`),
  CONSTRAINT `fk_reading_lists_user_id`
    FOREIGN KEY (`user_id`) REFERENCES `shareloop_users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reading_lists_book_id`
    FOREIGN KEY (`book_id`) REFERENCES `shareloop_books` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default item types
INSERT INTO `shareloop_item_types` (`name`, `slug`, `description`, `icon`) VALUES
('Kniha', 'book', 'Tradičná kniha', 'fa-book'),
('Puzzle', 'puzzle', 'Puzzle hra', 'fa-puzzle-piece'),
('Stolová hra', 'board_game', 'Stolová hra', 'fa-dice-d20'),
('Komiks', 'comic', 'Komiks', 'fa-book-open');

