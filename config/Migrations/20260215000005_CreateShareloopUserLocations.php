<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateShareloopUserLocations extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('shareloop_user_locations', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'null' => false,
        ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'null' => true,
            ])
            ->addColumn('address', 'string', [
                'limit' => 500,
                'null' => true,
            ])
            ->addColumn('is_default', 'boolean', [
                'default' => false,
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
            ->addForeignKey('user_id', 'shareloop_users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}

