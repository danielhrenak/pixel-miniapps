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
            ['title' => 'Stage 9', 'route' => 'scavenger_stage9', 'description' => 'Rozlusti emoji sifru a zadaj spravne heslo.'],
            ['title' => 'Stage Sudoku', 'route' => 'scavenger_stage_sudoku', 'description' => 'Vyries sudoku a opis spodny riadok bez medzier.'],
            ['title' => 'Stage Einstein', 'route' => 'scavenger_stage_einstein', 'description' => 'Poskladaj Einsteinovu hadanku presne podla indicií.'],
            ['title' => 'Stage Pocitanie', 'route' => 'scavenger_stage_pocitanie', 'description' => 'Postupne odpovedz na seriu otazok a odomkni odmenu.'],
            ['title' => 'Stage Floppy', 'route' => 'scavenger_stage_floppy', 'description' => 'Prelet cez prekazky vo Floppy Bird hre aj na mobile.'],
            ['title' => 'Stage Timebomb', 'route' => 'scavenger_stage_timebomb', 'description' => 'Co najpresnejsie odhadni 10 sekund bez hodin.'],
            ['title' => 'Stage Memory', 'route' => 'scavenger_stage_memory', 'description' => 'Zapamataj si chaoticku scenu a odpovedz na pamatove otazky.'],
            ['title' => 'Stage Mastermind', 'route' => 'scavenger_stage_mastermind', 'description' => 'Uhádni tajný 4-farebný kód do 8 pokusov a odomkni postupnú odmenu.'],
        ];

        $items = array_map(function (array $stage): array {
            $url = Router::url(['_name' => $stage['route']], true);

            return [
                'title' => $stage['title'],
                'description' => $stage['description'],
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

    public function stageTimebomb(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }

    public function stageMemory(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }

    public function stageMastermind(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }
}

