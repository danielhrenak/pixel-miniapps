# ShareLoop - Book & Item Sharing Application

ShareLoop je aplikácia na jednoduchu katalogizáciu a zdieľanie kníh a iných položiek (puzzle, stolové hry) v komunitách alebo firmách.

## Funkcionalita

### Verejné funkcie
- Prezeranie katalógu kníh bez prihlásenia
- Vyhľadávanie kníh

### Prihlásený užívateľ
- Pridanie nových kníh (skenovaním ISBN/čiarového kódu)
- Správa vlastných kníh
- Označenie kníh na:
  - Zdieľanie (požičiavanie alebo predaj)
  - Osobný zoznam na prečítanie
- Požičanie si kníh od iných užívateľov
- Sledovanie pozičaných kníh
- Správa miest (poličiek) v domácej knižnici
- Generovanie QR kódov pre každú knihu

### Administratívne funkcie
- Správa miest/poličiek v knižnici
- Správa používateľov
- Správa katalógu kníh

## Technológia

- CakePHP 5.2
- MySQL
- QR Code generovanie
- ISBN databázové API integrácie

## Databázové tabuľky

1. `users` - Užívatelia
2. `user_verifications` - Verifikácia emailov
3. `books` - Knihy v katalógu
4. `user_books` - Výskyty kníh (ktorý užívateľ má ktorú knihu)
5. `book_borrowings` - História požičiavania
6. `locations` - Miesta/poličky v knižnici
7. `user_locations` - Miesta patriace jednotlivým užívateľom alebo komunitám
8. `item_types` - Typy položiek (kniha, puzzle, stolová hra, atd.)

## API integrácie

- Google Books API
- OpenLibrary API
- ISBN Search API

## QR kódy

Každá kniha v systéme bude mať vlastný QR kód, ktorý vedúci na URL:
`/shareloop/books/{book_id}` - pri skenovaní sa zobrazí kniha a opcia na požičanie

