<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class TvAppAdminController extends AppController
{

    public function index()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $postsTable = TableRegistry::getTableLocator()->get('Posts');
        $items = $postsTable->find()->orderBy('created DESC')->all();

        $this->set(compact('items'));
    }

    public function toggle($id)
    {
        $this->request->allowMethod(['post']);
        $this->response = $this->response->withType('application/json');

        try {
            $postsTable = TableRegistry::getTableLocator()->get('Posts');
            $post = $postsTable->get($id);

            // Toggle hidden status
            $post->hidden = !$post->hidden;

            if ($postsTable->save($post)) {
                return $this->response->withStringBody(json_encode([
                    'success' => true,
                    'hidden' => (bool)$post->hidden
                ]));
            } else {
                return $this->response->withStatus(400)->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Chyba pri ukladaní položky'
                ]));
            }
        } catch (\Exception $e) {
            return $this->response->withStatus(400)->withStringBody(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
        }
    }

    public function add($screen_id)
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $postsTable = TableRegistry::getTableLocator()->get('Posts');

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Validate based on type
            $type = $data['type'] ?? null;
            $data['screen_id'] = $screen_id;

            if (empty($type)) {
                $this->Flash->error('Prosím vyberte typ položky.');
                $this->set(compact('screen_id'));
                return;
            }

            // Validate required fields based on type
            if ($type === 'image' && empty($data['image'])) {
                $this->Flash->error('URL obrázka je povinný.');
                $this->set(compact('screen_id'));
                return;
            }

            if ($type === 'video' && empty($data['video'])) {
                $this->Flash->error('URL videa je povinný.');
                $this->set(compact('screen_id'));
                return;
            }

            $post = $postsTable->newEntity($data);

            if ($postsTable->save($post)) {
                $this->Flash->success('Položka bola úspešne pridaná.');
                // Don't redirect - let the page refresh naturally with the success message
            } else {
                $this->Flash->error('Chyba pri pridávaní položky.');
            }
        }

        $this->set(compact('screen_id'));
    }
}
