<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateShareloopBookBorrowings extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('shareloop_book_borrowings', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'null' => false,
        ])
            ->addColumn('user_book_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('borrower_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('borrowed_at', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => false,
            ])
            ->addColumn('due_date', 'datetime', [
                'null' => true,
            ])
            ->addColumn('returned_at', 'datetime', [
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'limit' => 50,
                'default' => 'active',
                'null' => false,
            ])
            ->addColumn('notes', 'text', [
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addIndex(['user_book_id'])
            ->addIndex(['borrower_id'])
            ->addForeignKey('user_book_id', 'shareloop_user_books', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('borrower_id', 'shareloop_users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}

