<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateShareloopReadingLists extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('shareloop_reading_lists', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'null' => false,
        ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('book_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('priority', 'integer', [
                'default' => 0,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'limit' => 50,
                'default' => 'to_read',
                'null' => false,
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
            ->addIndex(['user_id'])
            ->addIndex(['book_id'])
            ->addIndex(['status'])
            ->addForeignKey('user_id', 'shareloop_users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('book_id', 'shareloop_books', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}

