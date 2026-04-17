<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Routing\Router;

class ScavengerController extends AppController
{
    public function index(): void
    {
        $this->viewBuilder()->setLayout('tailwin');

        $stages = [
            ['title' => 'Stage 9', 'route' => 'scavenger_stage9'],
            ['title' => 'Stage Sudoku', 'route' => 'scavenger_stage_sudoku'],
            ['title' => 'Stage Einstein', 'route' => 'scavenger_stage_einstein'],
            ['title' => 'Stage Pocitanie', 'route' => 'scavenger_stage_pocitanie'],
            ['title' => 'Stage Floppy', 'route' => 'scavenger_stage_floppy'],
        ];

        $items = array_map(function (array $stage): array {
            $url = Router::url(['_name' => $stage['route']], true);

            return [
                'title' => $stage['title'],
                'url' => $url,
                'qrUrl' => 'https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=' . rawurlencode($url),
            ];
        }, $stages);

        $this->set('items', $items);
    }

    public function stage9(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }

    public function stageSudoku(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }

    public function stageEinstein(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }

    public function stagePocitanie(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }

    public function stageFloppy(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }
}

