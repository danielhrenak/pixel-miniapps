<?php
namespace App\Controller;

use App\Controller\AppController;

class MonitoringController extends AppController
{

    public function index()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $screens = $this->fetchTable('Screens')
            ->find()
            ->toArray();
        $this->set('screens', $screens);
    }
    public function screen($screen_id)
    {
        $this->viewBuilder()->enableAutoLayout(false);

        // Fetch jokes from the articles table
        $comments = $this->fetchTable('Items')
            ->find()
            ->select(['content', 'category', 'priority'])
                ->where(['category IN' => ['text', 'image', 'empty'], 'screen_id' => $screen_id])
            ->toArray();

        // List of URLs to cycle through
        $urls = $this->fetchTable('Links')
            ->find()
            ->select(['url', 'duration'])
            ->where(['screen_id' => $screen_id])
            ->orderBy(['RAND()']);


        $screen = $this->fetchTable('Screens')->get($screen_id);

        $this->set('comment_section_enabled', $screen->comment_section_enabled);

        $this->set(compact('urls', 'comments'));
    }
}
