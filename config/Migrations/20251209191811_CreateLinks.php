<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateLinks extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('links', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'null' => false
        ])
            ->addColumn('title', 'text', ['null' => true])
            ->addColumn('url', 'text', ['null' => true])
            ->addColumn('screen_id', 'integer', ['null' => true])
            ->addColumn('duration', 'integer', ['default' => 100, 'null' => false])
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
