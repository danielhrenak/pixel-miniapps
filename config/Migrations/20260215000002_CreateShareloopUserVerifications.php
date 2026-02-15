<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateShareloopUserVerifications extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('shareloop_user_verifications', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'null' => false,
        ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('token', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('token_type', 'string', [
                'limit' => 50,
                'default' => 'email_verification',
                'null' => false,
            ])
            ->addColumn('expires_at', 'datetime', [
                'null' => true,
            ])
            ->addColumn('used', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addIndex(['user_id'])
            ->addIndex(['token'], ['unique' => true])
            ->addForeignKey('user_id', 'shareloop_users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}

