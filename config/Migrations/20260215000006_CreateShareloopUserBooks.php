<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateShareloopUserBooks extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('shareloop_user_books', ['id' => false, 'primary_key' => ['id']]);

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
            ->addColumn('location_id', 'integer', [
                'null' => true,
            ])
            ->addColumn('item_type_id', 'integer', [
                'default' => 1,
                'null' => false,
            ])
            ->addColumn('condition', 'string', [
                'limit' => 50,
                'default' => 'good',
                'null' => false,
            ])
            ->addColumn('sharing_type', 'string', [
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('notes', 'text', [
                'null' => true,
            ])
            ->addColumn('qr_code', 'string', [
                'limit' => 255,
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
            ->addIndex(['user_id'])
            ->addIndex(['book_id'])
            ->addIndex(['location_id'])
            ->addForeignKey('user_id', 'shareloop_users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('book_id', 'shareloop_books', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('location_id', 'shareloop_user_locations', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('item_type_id', 'shareloop_item_types', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
            ->create();
    }
}

