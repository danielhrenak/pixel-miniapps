<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class TvAppController extends AppController
{
    public function view ($screen_id)
    {
        $this->viewBuilder()->enableAutoLayout(false);

        // Load data from tables/API
        $links = $this->loadLinks($screen_id);
        $announcements = $this->loadAnnouncements();
        $wallPosts = $this->loadWallPosts($screen_id);

        // Pass to view as JSON
        $this->set(compact('links', 'announcements', 'wallPosts'));
    }

    private function loadLinks(int $screen_id)
    {
        $links = $this->fetchTable('Links')->find()->where(['screen_id' => $screen_id])->toArray();
        return $links;
    }

    private function loadAnnouncements()
    {
        // TODO: Replace with actual database query
        // $announcements = $this->Announcements->find()->toArray();
        return [];
    }

    private function loadWallPosts($screen_id)
    {
        $wallPosts = $this->fetchTable('Items')->find()->where(['screen_id' => $screen_id])
            ->orderBy(['RAND()'])
            ->toArray();
        return $wallPosts;
    }

}
