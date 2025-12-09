<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class InsertScreensData extends BaseMigration
{
    public function up(): void
    {
        $this->table('screens')
            ->insert([
                [
                    'id' => 1,
                    'title' => 'DA',
                    'comment_section_enabled' => 1,
                    'created' => '2025-12-09 19:14:36',
                    'modified' => '2025-12-09 19:14:41'
                ]
            ])
            ->saveData();
    }

    public function down(): void
    {
        $this->table('screens')->delete()->where(['id' => 1])->saveData();
    }
}
