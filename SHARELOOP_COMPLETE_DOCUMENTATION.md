# ShareLoop - Kompletná Dokumentácia

## 📚 Čo je ShareLoop?

ShareLoop je **moderná webová aplikácia na katalogizáciu a zdieľanie kníh** a iných položiek (puzzle, stolové hry) v komunitách a firmách. Umožňuje užívateľom:

- **Prezerať** katalóg dostupných kníh bez prihlásenia
- **Registrovať sa** prostredníctvom email verifikácie
- **Spravovať** svoju osobnú knižnicu
- **Zdieľať** svoje knihy - požičiavať ich ostatným alebo ich predávať
- **Požičiavať** si knihy od iných užívateľov
- **Vytvoriť** osobný zoznam na čítanie
- **Generovať** QR kódy pre každú knihu

---

## 🏗️ Architektúra

### Databázové tabuľky

#### 1. **shareloop_users**
Základné informácie o užívateľoch
- `id` - Primárny kľúč
- `email` - Emailová adresa (unikátna)
- `password_hash` - Heš hesla
- `first_name` - Meno
- `last_name` - Priezvisko
- `verified` - Či je email overený
- `active` - Či je účet aktívny
- `created`, `modified` - Časové pečiatky

#### 2. **shareloop_user_verifications**
Verifikačné tokeny pre email
- `id` - Primárny kľúč
- `user_id` - FK na shareloop_users
- `token` - Verifikačný token (unikátny)
- `token_type` - Typ tokenu (email_verification, password_reset)
- `expires_at` - Kedy token vypršal
- `used` - Či bol token už použitý

#### 3. **shareloop_item_types**
Typy položiek v knižnici (predvypĺňané)
- `id` - Primárny kľúč
- `name` - Názov typu (Kniha, Puzzle, Stolová hra...)
- `slug` - URL slug
- `description` - Popis
- `icon` - Font Awesome ikona

**Predvolené hodnoty:**
```
- Kniha (book) - fa-book
- Puzzle (puzzle) - fa-puzzle-piece
- Stolová hra (board_game) - fa-dice-d20
- Komiks (comic) - fa-book-open
```

#### 4. **shareloop_books**
Katalóg kníh v systéme
- `id` - Primárny kľúč
- `isbn` - ISBN (unikátny, voliteľný)
- `title` - Názov knihy
- `author` - Autor
- `publisher` - Vydavateľ
- `published_year` - Rok vydania
- `description` - Popis
- `cover_image_url` - URL na obal knihy
- `pages` - Počet strán
- `language` - Jazyk (sk, cs, en...)

#### 5. **shareloop_user_locations**
Miesta/poličky v knižnici patriace užívateľom
- `id` - Primárny kľúč
- `user_id` - FK na shareloop_users
- `name` - Názov umiestnenia
- `description` - Popis (napr. "Poličky v spálni")
- `address` - Fyzická adresa
- `is_default` - Je to predvolené miesto

**Príklady:**
- "Domáca knižnica"
- "Kancelária - 6. poschodie"
- "IT oddělení"

#### 6. **shareloop_user_books**
Jednotlivé výskyty kníh vlastnené užívateľmi
- `id` - Primárny kľúč
- `user_id` - FK na shareloop_users
- `book_id` - FK na shareloop_books
- `location_id` - FK na shareloop_user_locations
- `item_type_id` - FK na shareloop_item_types
- `condition` - Stav (excellent, good, fair, poor)
- `sharing_type` - Typ zdieľania (borrow, sell, both)
- `notes` - Poznámky užívateľa
- `qr_code` - URL na QR kód

#### 7. **shareloop_book_borrowings**
História požičiavania kníh
- `id` - Primárny kľúč
- `user_book_id` - FK na shareloop_user_books
- `borrower_id` - FK na shareloop_users (kto si knihu požičal)
- `borrowed_at` - Kedy bola požičaná
- `due_date` - Očakávaný dátum vrátenia
- `returned_at` - Kedy bola vrátená
- `status` - Stav (active, returned, overdue)
- `notes` - Poznámky

#### 8. **shareloop_reading_lists**
Osobný zoznam kníh na prečítanie
- `id` - Primárny kľúč
- `user_id` - FK na shareloop_users
- `book_id` - FK na shareloop_books
- `priority` - Priorita (vyššie číslo = vyššia priorita)
- `status` - Stav (to_read, reading, read)

---

## 📁 Štruktúra súborov

```
ShareLoop/
├── /config
│   ├── Migrations/
│   │   ├── 20260215000001_CreateShareloopUsers.php
│   │   ├── 20260215000002_CreateShareloopUserVerifications.php
│   │   ├── 20260215000003_CreateShareloopItemTypes.php
│   │   ├── 20260215000004_CreateShareloopBooks.php
│   │   ├── 20260215000005_CreateShareloopUserLocations.php
│   │   ├── 20260215000006_CreateShareloopUserBooks.php
│   │   ├── 20260215000007_CreateShareloopBookBorrowings.php
│   │   └── 20260215000008_CreateShareloopReadingLists.php
│   ├── schema/
│   │   └── shareloop.sql (kompletný SQL script)
│   └── shareloop.php (konfigurácia)
│
├── /src
│   ├── Controller/
│   │   ├── ShareloopAuthController.php (registrácia, prihlásenie)
│   │   ├── ShareloopBooksController.php (správa kníh)
│   │   └── ShareloopLocationsController.php (správa umiestnení)
│   │
│   ├── Model/
│   │   ├── Entity/
│   │   │   ├── ShareloopUser.php
│   │   │   ├── ShareloopUserVerification.php
│   │   │   ├── ShareloopItemType.php
│   │   │   ├── ShareloopBook.php
│   │   │   ├── ShareloopUserLocation.php
│   │   │   ├── ShareloopUserBook.php
│   │   │   ├── ShareloopBookBorrowing.php
│   │   │   └── ShareloopReadingList.php
│   │   │
│   │   └── Table/
│   │       ├── ShareloopUsersTable.php
│   │       ├── ShareloopUserVerificationsTable.php
│   │       ├── ShareloopItemTypesTable.php
│   │       ├── ShareloopBooksTable.php
│   │       ├── ShareloopUserLocationsTable.php
│   │       ├── ShareloopUserBooksTable.php
│   │       ├── ShareloopBookBorrowingsTable.php
│   │       └── ShareloopReadingListsTable.php
│   │
│   └── Service/
│       └── QrCodeService.php (generovanie QR kódov)
│
├── /templates
│   ├── ShareloopAuth/
│   │   ├── register.php (registračný formulár)
│   │   └── login.php (prihlasovací formulár)
│   │
│   ├── ShareloopBooks/
│   │   ├── index.php (katalóg kníh)
│   │   ├── view.php (detail knihy)
│   │   ├── add.php (pridať knihu)
│   │   ├── my_books.php (moja knižnica)
│   │   ├── my_reading_list.php (zoznam na čítanie)
│   │   └── search.php (vyhľadávanie)
│   │
│   ├── ShareloopLocations/
│   │   ├── index.php (zoznam umiestnení)
│   │   ├── add.php (pridať umiestnenie)
│   │   └── edit.php (upraviť umiestnenie)
│   │
│   └── email/
│       ├── html/
│       │   └── shareloop_email_verification.php
│       └── text/
│           └── shareloop_email_verification.php
│
├── /webroot
│   └── css/
│       └── shareloop.css (štýly)
│
├── /plugins
│   └── ShareLoop/
│       └── src/
│           └── Plugin.php
│
└── README.md
```

---

## 🔧 Inštalácia a nastavenie

### 1. Spustenie databázových migrácií

**Možnosť 1: Cez Cake Migrations**
```bash
cd /Users/dhrenak/projects/personal/pixel-miniapps
bin/cake migrations migrate
```

**Možnosť 2: Priamy SQL import**
```bash
mysql -u root -p < config/schema/shareloop.sql
```

### 2. Aktivácia pluginu

V súbore `config/plugins.php` pridajte:
```php
'ShareLoop' => [],
```

### 3. Konfigurácia routes

V súbore `config/routes.php` pridajte:
```php
$routes->scope('/shareloop', [], function (RouteBuilder $routes) {
    $routes->setRouteClass(DashedRoute::class);
    $routes->connect('/:controller', ['action' => 'index']);
    $routes->connect('/:controller/:action/*', []);
});
```

### 4. Nastavenie emailu

V súbore `config/app.php` nakonfigurujte:
```php
'Email' => [
    'default' => [
        'host' => 'smtp.mailtrap.io', // alebo váš SMTP server
        'port' => 2525,
        'username' => env('EMAIL_USERNAME'),
        'password' => env('EMAIL_PASSWORD'),
        'className' => 'Smtp',
    ],
],
```

### 5. Nastavenie CSS

V layoute `templates/layout/default.php` pridajte:
```html
<?= $this->Html->css('shareloop.css') ?>
```

---

## 🌐 API Routes

### Autentifikácia
- `POST /shareloop/auth/register` - Registrácia
- `GET /shareloop/auth/verify/{token}` - Verifikácia emailu
- `POST /shareloop/auth/login` - Prihlásenie
- `GET /shareloop/auth/logout` - Odhlásenie

### Katalóg kníh (verejné)
- `GET /shareloop/books/index` - Zoznam všetkých kníh
- `GET /shareloop/books/view/{id}` - Detail knihy
- `GET /shareloop/books/search` - Vyhľadávanie

### Moja knižnica (prihlásiť sa)
- `GET /shareloop/books/my-books` - Moja knižnica
- `GET /shareloop/books/add` - Formulár na pridanie
- `POST /shareloop/books/add` - Pridať knihu
- `GET /shareloop/books/my-reading-list` - Môj zoznam
- `GET /shareloop/books/add-to-reading-list/{bookId}` - Pridať do zoznamu
- `GET /shareloop/books/borrow/{userBookId}` - Požičať si
- `GET /shareloop/books/return-book/{borrowingId}` - Vrátiť

### Umiestnenia (prihlásiť sa)
- `GET /shareloop/locations/index` - Zoznam umiestnení
- `GET /shareloop/locations/add` - Formulár na vytvorenie
- `POST /shareloop/locations/add` - Vytvoriť
- `GET /shareloop/locations/edit/{id}` - Formulár na úpravu
- `POST /shareloop/locations/edit/{id}` - Uložiť zmeny
- `GET /shareloop/locations/delete/{id}` - Odstrániť
- `GET /shareloop/locations/set-default/{id}` - Nastaviť ako predvolené

---

## 🎨 Frontend features

### Registrácia a Autentifikácia
- Email verifikácia (7 dní platnosti)
- Bezpečné heslo (bcrypt)
- Email notifikácie

### Katalóg kníh
- Grid displej s obálkami
- Vyhľadávanie (názov, autor, ISBN)
- Pagination
- Detail stránka s dostupnými kópiami

### Moja knižnica
- Zoznam mojich kníh
- Filtrovanie podľa umiestnenia
- Možnosť zdieľania (požičiavanie/predaj)
- Generovanie QR kódov

### Umiestnenia
- Vytvorenie vlastných poličiek
- Priradenie kníh do umiestnení
- Predvolené miesto

### Zoznam na čítanie
- Prioritizovanie
- Sledovanie stavu

### QR kódy
- Automatické generovanie
- URL: `https://api.qrserver.com/v1/create-qr-code/?...`
- Priame skenovaní vedúce na detail knihy

---

## 💡 Budúce rozšírenia

1. **ISBN API integrácia**
   - Google Books API
   - OpenLibrary API
   - Automatické načítavanie údajov

2. **QR kód management**
   - Lokálne generovanie (phpqrcode)
   - Tlačiteľné QR kódy
   - QR scanner v aplikácii

3. **Komunity a skupiny**
   - Vytvorenie knižníc pre skupiny
   - Zdieľanie v komunite
   - Notifikácie dostupnosti

4. **Pokročilé vyhľadávanie**
   - Filtrovanie podľa kategórie
   - Podľa dostupnosti
   - Podľa lokácie

5. **Rating a recenzie**
   - Hodnotenie kníh
   - Komentáre
   - Odporúčania

6. **Systém reputácie**
   - Recenzenti
   - Aktívne používatele
   - Odznamky

7. **Notifikácie**
   - Email notifikácie
   - In-app notifikácie
   - Push notifikácie

8. **Admin panel**
   - Správa užívateľov
   - Správa kníh
   - Analýzy

---

## 🔐 Bezpečnosť

- ✅ Email verifikácia
- ✅ CSRF ochrana
- ✅ SQL injection ochrana (CakePHP ORM)
- ✅ XSS ochrana (h() escaping)
- ✅ Bcrypt hešovanie hesiel
- ✅ HTTPS ready
- ✅ Session management
- ✅ Role-based access control (RBAC) - budúce

---

## 📊 Štatistiky

- **8 databázových tabuliek**
- **8 Entity tried**
- **8 Table tried**
- **3 Controllery**
- **11 View šablón**
- **1 Service (QR Code)**
- **Viac ako 1000 riadkov PHP kódu**

---

## 📝 Licencia

MIT License

---

## 🤝 Kontakt

- Vytvárač: GitHub Copilot
- Dátum vytvorenia: Február 2026
- Verzia: 1.0.0

---

**Status: ✅ HOTOVO**

Aplikácia ShareLoop je plne funkčná a pripravená na nasadenie!

