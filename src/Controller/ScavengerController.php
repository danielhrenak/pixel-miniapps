<?php
declare(strict_types=1);

namespace App\Controller;

class ScavengerController extends AppController
{
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
}

