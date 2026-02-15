<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateShareloopUsers extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('shareloop_users', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'null' => false,
        ])
            ->addColumn('email', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password_hash', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('first_name', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('last_name', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('verified', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('active', 'boolean', [
                'default' => true,
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
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}

