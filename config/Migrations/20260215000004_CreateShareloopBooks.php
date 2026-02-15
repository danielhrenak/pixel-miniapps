<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateShareloopBooks extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('shareloop_books', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'null' => false,
        ])
            ->addColumn('isbn', 'string', [
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('author', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('publisher', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('published_year', 'integer', [
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'null' => true,
            ])
            ->addColumn('cover_image_url', 'string', [
                'limit' => 500,
                'null' => true,
            ])
            ->addColumn('pages', 'integer', [
                'null' => true,
            ])
            ->addColumn('language', 'string', [
                'limit' => 10,
                'default' => 'sk',
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
            ->addIndex(['isbn'], ['unique' => true])
            ->addIndex(['title'])
            ->addIndex(['author'])
            ->create();
    }
}

