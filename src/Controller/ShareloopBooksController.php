<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ShareLoop Books Controller
 *
 * @property \App\Model\Table\ShareloopBooksTable $ShareloopBooks
 * @property \App\Model\Table\ShareloopUserBooksTable $ShareloopUserBooks
 * @property \App\Model\Table\ShareloopReadingListsTable $ShareloopReadingLists
 * @property \App\Model\Table\ShareloopBookBorrowingsTable $ShareloopBookBorrowings
 */
class ShareloopBooksController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index', 'view', 'search']);
    }

    /**
     * Index - Browse all books
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 20,
            'order' => ['ShareloopBooks.created' => 'DESC'],
        ];

        $books = $this->paginate('ShareloopBooks');

        $this->set('books', $books);
        $this->set('pageTitle', __('Katalóg kníh - ShareLoop'));
        return null;
    }

    /**
     * View - Book detail page
     */
    public function view($id = null)
    {
        $book = $this->ShareloopBooks->get($id, [
            'contain' => ['ShareloopUserBooks' => ['ShareloopUsers', 'ShareloopUserLocations']],
        ]);

        $this->set('book', $book);
        $this->set('pageTitle', $book->title);

        // If logged in, show borrowing options
        if ($this->Authentication->getIdentity()) {
            $user = $this->Authentication->getIdentity();
            $userBooks = $this->ShareloopUserBooks->find()
                ->where(['user_id' => $user->id, 'book_id' => $id])
                ->toArray();
            $this->set('userBooks', $userBooks);
        }
        return null;
    }

    /**
     * Search books
     */
    public function search()
    {
        $query = null;
        $results = [];

        if ($this->request->is(['get', 'post'])) {
            $query = $this->request->getQuery('q') ?: $this->request->getData('q');

            if (!empty($query)) {
                $results = $this->ShareloopBooks->find()
                    ->where([
                        'OR' => [
                            'title LIKE' => '%' . $query . '%',
                            'author LIKE' => '%' . $query . '%',
                            'isbn' => $query,
                        ]
                    ])
                    ->limit(50)
                    ->toArray();
            }
        }

        $this->set('query', $query);
        $this->set('results', $results);
        $this->set('pageTitle', __('Hľadať knihu'));
        return null;
    }

    /**
     * Add new book (authenticated users only)
     */
    public function add(): ?\Cake\Http\Response
    {
        if ($this->request->is('post')) {
            $user = $this->Authentication->getIdentity();
            $data = $this->request->getData();

            // Check if book already exists (by ISBN)
            $existingBook = null;
            if (!empty($data['isbn'])) {
                $existingBook = $this->ShareloopBooks->findByIsbn($data['isbn'])->first();
            }

            if ($existingBook) {
                $book = $existingBook;
            } else {
                // Create new book
                $book = $this->ShareloopBooks->newEntity($data);
                if (!$this->ShareloopBooks->save($book)) {
                    $this->Flash->error(__('Chyba pri vytváraní knihy'));
                    return null;
                }
            }

            // Create user book entry
            $userBook = $this->ShareloopUserBooks->newEntity([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'location_id' => $data['location_id'] ?? null,
                'item_type_id' => $data['item_type_id'] ?? 1,
                'condition' => $data['condition'] ?? 'good',
                'sharing_type' => $data['sharing_type'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            if ($this->ShareloopUserBooks->save($userBook)) {
                $this->Flash->success(__('Kniha bola úspešne pridaná'));
                return $this->redirect(['action' => 'myBooks']);
            }

            $this->Flash->error(__('Chyba pri pridávaní knihy'));
            return null;
        }

        $locations = $this->ShareloopUserBooks->ShareloopUsers->ShareloopUserLocations->find()
            ->where(['user_id' => $this->Authentication->getIdentity()->id])
            ->toArray();

        $itemTypes = $this->ShareloopBooks->ShareloopItemTypes->find()->toArray();

        $this->set('locations', $locations);
        $this->set('itemTypes', $itemTypes);
        $this->set('pageTitle', __('Pridať novú knihu'));
        return null;
    }

    /**
     * My Books - User's library
     */
    public function myBooks()
    {
        $user = $this->Authentication->getIdentity();

        $userBooks = $this->ShareloopUserBooks->find()
            ->contain(['ShareloopBooks', 'ShareloopUserLocations'])
            ->where(['user_id' => $user->id])
            ->order(['ShareloopUserBooks.created' => 'DESC'])
            ->toArray();

        $this->set('userBooks', $userBooks);
        $this->set('pageTitle', __('Moja knižnica'));
        return null;
    }

    /**
     * My Reading List - User's reading list
     */
    public function myReadingList()
    {
        $user = $this->Authentication->getIdentity();

        $readingList = $this->ShareloopReadingLists->find()
            ->contain(['ShareloopBooks'])
            ->where(['user_id' => $user->id])
            ->order(['priority' => 'DESC', 'created' => 'DESC'])
            ->toArray();

        $this->set('readingList', $readingList);
        $this->set('pageTitle', __('Môj zoznam na čítanie'));
        return null;
    }

    /**
     * Add to reading list
     */
    public function addToReadingList($bookId = null)
    {
        $user = $this->Authentication->getIdentity();

        $exists = $this->ShareloopReadingLists->findByUserIdAndBookId($user->id, $bookId)->first();

        if ($exists) {
            $this->Flash->error(__('Kniha je už na vašom zozname'));
            return $this->redirect($this->referer());
        }

        $entry = $this->ShareloopReadingLists->newEntity([
            'user_id' => $user->id,
            'book_id' => $bookId,
            'status' => 'to_read',
            'priority' => 0,
        ]);

        if ($this->ShareloopReadingLists->save($entry)) {
            $this->Flash->success(__('Kniha bola pridaná na váš zoznam'));
        } else {
            $this->Flash->error(__('Chyba pri pridávaní na zoznam'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Borrow a book
     */
    public function borrow($userBookId = null)
    {
        $user = $this->Authentication->getIdentity();
        $userBook = $this->ShareloopUserBooks->get($userBookId);

        if (!$userBook) {
            throw new \Cake\Http\Exception\NotFoundException();
        }

        // Check if already borrowed
        $activeBorrowing = $this->ShareloopBookBorrowings->find()
            ->where(['user_book_id' => $userBookId, 'status' => 'active'])
            ->first();

        if ($activeBorrowing) {
            $this->Flash->error(__('Táto kniha je už požičaná'));
            return $this->redirect($this->referer());
        }

        $borrowing = $this->ShareloopBookBorrowings->newEntity([
            'user_book_id' => $userBookId,
            'borrower_id' => $user->id,
            'status' => 'active',
            'borrowed_at' => date('Y-m-d H:i:s'),
        ]);

        if ($this->ShareloopBookBorrowings->save($borrowing)) {
            $this->Flash->success(__('Kniha bola požičaná'));
        } else {
            $this->Flash->error(__('Chyba pri požičaní knihy'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Return a borrowed book
     */
    public function returnBook($borrowingId = null)
    {
        $user = $this->Authentication->getIdentity();
        $borrowing = $this->ShareloopBookBorrowings->get($borrowingId, [
            'contain' => ['ShareloopUserBooks'],
        ]);

        if (!$borrowing || $borrowing->borrower_id !== $user->id) {
            throw new \Cake\Http\Exception\ForbiddenException();
        }

        $borrowing->returned_at = date('Y-m-d H:i:s');
        $borrowing->status = 'returned';

        if ($this->ShareloopBookBorrowings->save($borrowing)) {
            $this->Flash->success(__('Kniha bola vrátená'));
        } else {
            $this->Flash->error(__('Chyba pri vrátení knihy'));
        }

        return $this->redirect($this->referer());
    }
}

