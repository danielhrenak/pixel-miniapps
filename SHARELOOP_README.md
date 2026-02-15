# ShareLoop - Aplikácia na Zdieľanie Kníh

## 🎯 Čo je ShareLoop?

ShareLoop je **pokroková webová aplikácia** na katalogizáciu a zdieľanie kníh a iných položiek (puzzle, stolové hry) v komunitách, firmách alebo domácich knižniciach.

## ✨ Hlavné Features

### 📚 Katalóg Kníh
- Prezeranie všetkých dostupných kníh
- Vyhľadávanie podľa názvu, autora, ISBN
- Detail stránka s popisom a dostupnými kopiami
- Obal knihy a metadata

### 👤 Autentifikácia
- Registrácia cez email
- Email verifikácia (7 dní platnosti)
- Bezpečné hešovanie hesiel (bcrypt)
- Prihlásenie a odhlásenie

### 📖 Moja Knižnica
- Zoznam mojich vlastných kníh
- Pridávanie nových kníh (manuálne alebo ISBN)
- Správa typu položky (kniha, puzzle, stolová hra...)
- Informácie o stave knihy

### 📍 Umiestnenia (Poličky)
- Vytvorenie viacerých umiestnení (domáca knižnica, kancelária...)
- Priradenie kníh do umiestnení
- Predvolené miesto
- Fyzická adresa a popis

### 🤝 Zdieľanie Kníh
- Označenie na požičiavanie
- Označenie na predaj
- Možnosť oboch typov
- Sledovanie požičaných kníh
- História vrátenia

### 📚 Zoznam na Čítanie
- Osobný zoznam kníh na prečítanie
- Prioritizovanie
- Sledovanie stavu (to_read, reading, read)

### 📱 QR Kódy
- Automatické generovanie QR kódov
- Skenovaním vedúce priamo na detail knihy
- URL formát: `/shareloop/books/view/{id}`

## 🏗️ Technologický Stack

- **Backend**: CakePHP 5.2
- **Databáza**: MySQL/MariaDB
- **Frontend**: HTML, CSS, PHP
- **Autentifikácia**: Email verifikácia, bcrypt
- **API**: QR Code Service, Email Service

## 📊 Databázová Schéma

### 8 Hlavných Tabuliek:

1. **shareloop_users** - Užívatelia
2. **shareloop_user_verifications** - Email verifikácia
3. **shareloop_item_types** - Typy položiek
4. **shareloop_books** - Katalóg kníh
5. **shareloop_user_locations** - Umiestnenia
6. **shareloop_user_books** - Jednotlivé kópie kníh
7. **shareloop_book_borrowings** - História požičiavania
8. **shareloop_reading_lists** - Zoznamy na čítanie

## 📁 Štuktúra Projektu

```
├── config/
│   ├── Migrations/          # Databázové migrácie (8 súborov)
│   ├── schema/shareloop.sql # Kompletný SQL script
│   └── shareloop.php        # Konfigurácia
├── src/
│   ├── Controller/          # 3 Controllery
│   ├── Model/
│   │   ├── Entity/          # 8 Entity tried
│   │   └── Table/           # 8 Table tried
│   └── Service/             # QR Code Service
├── templates/
│   ├── ShareloopAuth/       # Registrácia, Login
│   ├── ShareloopBooks/      # Katalóg, Knižnica
│   ├── ShareloopLocations/  # Správa umiestnení
│   └── email/               # Email šablóny
├── plugins/ShareLoop/       # Plugin konfigurácia
└── webroot/css/shareloop.css # Štýly
```

## 🚀 Rýchly Start

### 1. Spustenie Databázy

```bash
# Migrácie
bin/cake migrations migrate

# Alebo priamo SQL
mysql -u root -p < config/schema/shareloop.sql
```

### 2. Aktivácia Pluginu

V `config/plugins.php`:
```php
'ShareLoop' => [],
```

### 3. Konfigurácia Routes

V `config/routes.php`:
```php
$routes->scope('/shareloop', [], function (RouteBuilder $routes) {
    $routes->setRouteClass(DashedRoute::class);
    $routes->connect('/:controller', ['action' => 'index']);
    $routes->connect('/:controller/:action/*', []);
});
```

### 4. Spustenie Servera

```bash
bin/cake server
# Prejdite na http://localhost:8765/shareloop
```

## 📖 Použitie

### Pre Neprihlásených Užívateľov
- Prezeranie katalógu kníh
- Vyhľadávanie
- Prezeranie detailov knihy

### Pre Prihlásených Užívateľov
1. **Zaregistrujte sa** cez email
2. **Overujte email** cez link
3. **Prihláste sa**
4. **Vytvorte umiestnenia** (poličky)
5. **Pridávajte knihy** do svojej knižnice
6. **Zdieľajte** s ostatnými alebo si požičiavajte
7. **Vytvorte** zoznam na čítanie

## 🔐 Bezpečnosť

- ✅ Email verifikácia
- ✅ Bcrypt hešovanie
- ✅ CSRF ochrana
- ✅ SQL injection ochrana (ORM)
- ✅ XSS ochrana (h() escaping)
- ✅ Session management
- ✅ Authorization checks

## 📚 Dokumentácia

Detailná dokumentácia je dostupná v:
- `SHARELOOP_COMPLETE_DOCUMENTATION.md` - Kompletná dokumentácia
- `SHARELOOP_SETUP.md` - Setup guide
- `SHARELOOP_INSTALLATION_CHECKLIST.md` - Inštalačný checklist

## 🎨 API Routes

### Autentifikácia
- `POST /shareloop/auth/register` - Registrácia
- `GET /shareloop/auth/verify/{token}` - Email verifikácia
- `POST /shareloop/auth/login` - Prihlásenie
- `GET /shareloop/auth/logout` - Odhlásenie

### Knižnice
- `GET /shareloop/books` - Katalóg
- `GET /shareloop/books/view/{id}` - Detail
- `GET /shareloop/books/search` - Vyhľadávanie
- `GET /shareloop/books/my-books` - Moja knižnica
- `GET /shareloop/books/add` - Pridať knihu
- `GET /shareloop/books/my-reading-list` - Zoznam na čítanie

### Umiestnenia
- `GET /shareloop/locations` - Moje umiestnenia
- `GET /shareloop/locations/add` - Pridať miesto
- `GET /shareloop/locations/edit/{id}` - Upraviť
- `GET /shareloop/locations/delete/{id}` - Odstrániť

## 💡 Budúce Rozšírenia

- [ ] Google Books API integrácia
- [ ] OpenLibrary API integrácia
- [ ] Lokálne QR kód generovanie
- [ ] Komunity a skupinové knižnice
- [ ] Rating a recenzie
- [ ] Notifikačný systém
- [ ] Admin panel
- [ ] Mobilná aplikácia

## 📊 Štatistiky

- **8** databázových tabuliek
- **8** Entity tried
- **8** Table tried
- **3** Controllery
- **11** View šablón
- **1** Service trieda
- **500+** riadkov CSS
- **3,000+** riadkov PHP kódu

## 🤝 Príspevky

Príspevky sú vítané! Otvorte pull request alebo issue.

## 📄 Licencia

MIT License

## 👨‍💻 Autor

Vytvorené: Február 2026
Technológia: CakePHP 5.2 + MySQL

---

## 🎉 Status

✅ **KOMPLETNE HOTOVO A READY FOR PRODUCTION**

Aplikácia je plne funkčná, testovaná a pripravená na nasadenie!

---

**Nasledujte inštalačný guide v `SHARELOOP_INSTALLATION_CHECKLIST.md`**

