<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Mailer\Mailer;
use Cake\Utility\Text;

/**
 * ShareLoop Auth Controller
 *
 * @property \App\Model\Table\ShareloopUsersTable $ShareloopUsers
 * @property \App\Model\Table\ShareloopUserVerificationsTable $ShareloopUserVerifications
 */
class ShareloopAuthController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['register', 'verify', 'login']);
    }

    /**
     * Register - GET form or POST register
     */
    public function register()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Validate email format
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->Flash->error(__('Neplatná emailová adresa'));
                return $this->redirect(['action' => 'register']);
            }

            // Check if user already exists
            $existingUser = $this->ShareloopUsers->findByEmail($data['email'])->first();
            if ($existingUser) {
                $this->Flash->error(__('Používateľ s touto emailovou adresou už existuje'));
                return $this->redirect(['action' => 'register']);
            }

            // Create new user
            $user = $this->ShareloopUsers->newEntity([
                'email' => $data['email'],
                'first_name' => $data['first_name'] ?? null,
                'last_name' => $data['last_name'] ?? null,
                'verified' => false,
            ]);

            if ($this->ShareloopUsers->save($user)) {
                // Generate verification token
                $token = Text::uuid();
                $verification = $this->ShareloopUserVerifications->newEntity([
                    'user_id' => $user->id,
                    'token' => $token,
                    'token_type' => 'email_verification',
                    'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')),
                ]);

                if ($this->ShareloopUserVerifications->save($verification)) {
                    // Send verification email
                    try {
                        $mailer = new Mailer('default');
                        $mailer
                            ->setTo($user->email)
                            ->setSubject(__('Overenie emailu - ShareLoop'))
                            ->setTemplate('shareloop_email_verification')
                            ->setViewVars([
                                'user' => $user,
                                'token' => $token,
                                'verifyUrl' => $this->Url->build(['action' => 'verify', $token], true),
                            ])
                            ->send();
                    } catch (\Exception $e) {
                        $this->log('Email sending failed: ' . $e->getMessage());
                    }

                    $this->Flash->success(__('Registrácia úspešná! Skontrolujte si email pre verifikačný kód.'));
                    return $this->redirect(['action' => 'login']);
                }
            }

            $this->Flash->error(__('Chyba pri registrácii'));
        }

        $this->set('pageTitle', __('Registrácia - ShareLoop'));
        return null;
    }

    /**
     * Verify email token
     */
    public function verify($token = null)
    {
        if (!$token) {
            throw new NotFoundException(__('Neplatný verifikačný token'));
        }

        $verification = $this->ShareloopUserVerifications
            ->findByToken($token)
            ->contain('ShareloopUsers')
            ->first();

        if (!$verification) {
            throw new NotFoundException(__('Verifikačný token neexistuje'));
        }

        if ($verification->used) {
            $this->Flash->error(__('Verifikačný token bol už použitý'));
            return $this->redirect(['action' => 'login']);
        }

        if ($verification->expires_at && $verification->expires_at < date('Y-m-d H:i:s')) {
            $this->Flash->error(__('Verifikačný token vypršal'));
            return $this->redirect(['action' => 'register']);
        }

        // Mark user as verified
        $user = $verification->shareloop_user;
        $user->verified = true;
        $this->ShareloopUsers->save($user);

        // Mark token as used
        $verification->used = true;
        $this->ShareloopUserVerifications->save($verification);

        $this->Flash->success(__('Email bol úspešne overený! Môžete sa teraz prihlásiť.'));
        return $this->redirect(['action' => 'login']);
    }

    /**
     * Login
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();

            if ($result && $result->isValid()) {
                return $this->redirect(['controller' => 'ShareloopBooks', 'action' => 'index']);
            }

            $this->Flash->error(__('Nesprávny email alebo heslo'));
            return null;
        }

        $this->set('pageTitle', __('Prihlásenie - ShareLoop'));
        return null;
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }
}

