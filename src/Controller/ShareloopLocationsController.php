<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ShareLoop Locations Controller
 *
 * @property \App\Model\Table\ShareloopUserLocationsTable $ShareloopUserLocations
 */
class ShareloopLocationsController extends AppController
{
    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        parent::beforeRender($event);

        // Use the shareloop layout from templates/layout/shareloop.php
        $this->viewBuilder()->setLayout('shareloop');
    }

    /**
     * List user's locations
     */
    public function index()
    {
        $user = $this->Authentication->getIdentity();

        $locations = $this->ShareloopUserLocations->find()
            ->where(['user_id' => $user->id])
            ->order(['is_default' => 'DESC', 'name' => 'ASC'])
            ->toArray();

        $this->set('locations', $locations);
        $this->set('pageTitle', __('Moje umiestnenia kníh'));
    }

    /**
     * Add new location
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $user = $this->Authentication->getIdentity();
            $data = $this->request->getData();

            // If this is the first location, make it default
            $existingCount = $this->ShareloopUserLocations->find()
                ->where(['user_id' => $user->id])
                ->count();

            $location = $this->ShareloopUserLocations->newEntity([
                'user_id' => $user->id,
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'address' => $data['address'] ?? null,
                'is_default' => $existingCount === 0 || ($data['is_default'] ?? false),
            ]);

            if ($this->ShareloopUserLocations->save($location)) {
                $this->Flash->success(__('Umiestnenie bolo vytvorené'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Chyba pri vytváraní umiestnenia'));
        }

        $this->set('pageTitle', __('Pridať nové umiestnenie'));
        return null;
    }

    /**
     * Edit location
     */
    public function edit($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $location = $this->ShareloopUserLocations->get($id);

        if ($location->user_id !== $user->id) {
            throw new \Cake\Http\Exception\ForbiddenException();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $location = $this->ShareloopUserLocations->patchEntity($location, $data);

            if ($this->ShareloopUserLocations->save($location)) {
                $this->Flash->success(__('Umiestnenie bolo aktualizované'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Chyba pri aktualizácii umiestnenia'));
        }

        $this->set('location', $location);
        $this->set('pageTitle', __('Upraviť umiestnenie'));
        return null;
    }

    /**
     * Delete location
     */
    public function delete($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $location = $this->ShareloopUserLocations->get($id);

        if ($location->user_id !== $user->id) {
            throw new \Cake\Http\Exception\ForbiddenException();
        }

        if ($this->ShareloopUserLocations->delete($location)) {
            $this->Flash->success(__('Umiestnenie bolo vymazané'));
        } else {
            $this->Flash->error(__('Chyba pri mazaní umiestnenia'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Set as default
     */
    public function setDefault($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $location = $this->ShareloopUserLocations->get($id);

        if ($location->user_id !== $user->id) {
            throw new \Cake\Http\Exception\ForbiddenException();
        }

        // Set all other locations to not default
        $this->ShareloopUserLocations->updateAll(
            ['is_default' => false],
            ['user_id' => $user->id]
        );

        // Set this one as default
        $location->is_default = true;
        $this->ShareloopUserLocations->save($location);

        $this->Flash->success(__('Umiestnenie bolo nastavené ako predvolené'));
        return $this->redirect(['action' => 'index']);
    }
}

