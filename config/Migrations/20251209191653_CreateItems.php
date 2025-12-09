<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateItems extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('items', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'null' => false,
        ])
            ->addColumn('name', 'text', ['null' => true])
            ->addColumn('screen_id', 'integer', ['null' => true])
            ->addColumn('content', 'text', ['null' => true])
            ->addColumn('author', 'text', ['null' => true])
            ->addColumn('category', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('priority', 'integer', ['null' => true])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => false
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
                'null' => false
            ])
            ->addPrimaryKey(['id'])
            ->create();
    }
}
