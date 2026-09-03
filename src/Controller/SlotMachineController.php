<?php
declare(strict_types=1);

namespace App\Controller;

class SlotMachineController extends AppController
{
    public function index(): void
    {
        $this->viewBuilder()->setLayout('tailwin');
    }
}
