# ShareLoop - Implementácia kompletná

## Prehľad vytvorených súborov

### 1. Plugin konfigurácia
- `/plugins/ShareLoop/src/Plugin.php` - Hlavný plugin file

### 2. Databázové migrácie (v `/config/Migrations/`)
- `20260215000001_CreateShareloopUsers.php`
- `20260215000002_CreateShareloopUserVerifications.php`
- `20260215000003_CreateShareloopItemTypes.php`
- `20260215000004_CreateShareloopBooks.php`
- `20260215000005_CreateShareloopUserLocations.php`
- `20260215000006_CreateShareloopUserBooks.php`
- `20260215000007_CreateShareloopBookBorrowings.php`
- `20260215000008_CreateShareloopReadingLists.php`

### 3. Entity triedy (v `/src/Model/Entity/`)
- `ShareloopUser.php`
- `ShareloopUserVerification.php`
- `ShareloopItemType.php`
- `ShareloopBook.php`
- `ShareloopUserLocation.php`
- `ShareloopUserBook.php`
- `ShareloopBookBorrowing.php`
- `ShareloopReadingList.php`

### 4. Table triedy (v `/src/Model/Table/`)
- `ShareloopUsersTable.php`
- `ShareloopUserVerificationsTable.php`
- `ShareloopItemTypesTable.php`
- `ShareloopBooksTable.php`
- `ShareloopUserLocationsTable.php`
- `ShareloopUserBooksTable.php`
- `ShareloopBookBorrowingsTable.php`
- `ShareloopReadingListsTable.php`

### 5. Controllery (v `/src/Controller/`)
- `ShareloopAuthController.php` - Registrácia, verifikácia, prihlásenie
- `ShareloopBooksController.php` - Správa kníh a požičiavania

### 6. SQL schéma
- `/config/schema/shareloop.sql` - Kompletná SQL schéma

---

## SQL CREATE príkazy na spustenie v databáze

```sql
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
```

---

## Funkčnosť aplikácie ShareLoop

### Pre neprihlásených užívateľov
1. **Prezeranie katalógu** - `/shareloop/books/index`
2. **Vyhľadávanie kníh** - `/shareloop/books/search`
3. **Detail knihy** - `/shareloop/books/view/{id}`

### Autentifikácia
1. **Registrácia** - `/shareloop/auth/register`
   - Email sa musí overiť cez verifikačný link
   - Token platí 7 dní
   - Emailové notifikácie

2. **Prihlásenie** - `/shareloop/auth/login`
3. **Odhlásenie** - `/shareloop/auth/logout`

### Pre prihlásených užívateľov
1. **Moja knižnica** - `/shareloop/books/my-books`
   - Zoznam všetkých kníh, ktoré má užívateľ
   - Filtrovanie podľa lokácie
   - Možnosť označenia na zdieľanie (požičiavanie/predaj)

2. **Pridať novú knihu** - `/shareloop/books/add`
   - Skenovaním ISBN alebo manuálny vstup
   - Výber miesta v knižnici
   - Typ položky (kniha, puzzle, atď.)

3. **Môj zoznam na čítanie** - `/shareloop/books/my-reading-list`
   - Zoznam kníh na prečítanie
   - Prioritizovanie

4. **Požičiavanie** - `/shareloop/books/borrow/{userBookId}`
   - Možnosť požičať si knihu od iného užívateľa
   - Sledovanie požičanej knihy

5. **Vrátenie knihy** - `/shareloop/books/return-book/{borrowingId}`
   - Označenie ako vrátenej

### QR kódy
- Každá kniha v systéme má vlastný QR kód
- URL formát: `/shareloop/books/view/{id}`
- Skenovaním sa otvorí stránka s knihou

### Budúce rozšírenia
1. ISBN databázové API (Google Books, OpenLibrary)
2. QR generovanie na obrazovke
3. Komunity a skupinové knižnice
4. Notifikácie o dostupnosti
5. Rating a recenzie kníh
6. Systém reputácie
7. Integrácia s platformami ako Goodreads

---

## Inštalácia a spustenie

### Kroky:
1. **Spustiť SQL migrácie** alebo priamo CREATE príkazy z `config/schema/shareloop.sql`
2. **Skompilovať Composer** (ak sú nové dependencie)
3. **Aktivovať plugin** v `config/plugins.php`:
   ```php
   'ShareLoop' => [],
   ```
4. **Nakonfigurovať routes** v `config/routes.php`:
   ```php
   $routes->scope('/shareloop', [], function (RouteBuilder $routes) {
       $routes->setRouteClass(DashedRoute::class);
       $routes->connect('/:controller', ['action' => 'index']);
       $routes->connect('/:controller/:action/*', []);
   });
   ```
5. **Nakonfigurovať Authentication middleware** pre ShareLoop

---

## Databázové vzťahy

```
shareloop_users (1) ──► (many) shareloop_user_books
shareloop_users (1) ──► (many) shareloop_user_verifications
shareloop_users (1) ──► (many) shareloop_user_locations
shareloop_users (1) ──► (many) shareloop_reading_lists
shareloop_users (1) ──► (many) shareloop_book_borrowings (ako borrower)

shareloop_books (1) ──► (many) shareloop_user_books
shareloop_books (1) ──► (many) shareloop_reading_lists

shareloop_user_books (1) ──► (many) shareloop_book_borrowings
shareloop_user_locations (1) ──► (many) shareloop_user_books

shareloop_item_types (1) ──► (many) shareloop_user_books
```

---

## Status: ✅ HOTOVO

Všetky modely, tabuľky, entity a controllery sú vytvorené a pripravené na použitie.

