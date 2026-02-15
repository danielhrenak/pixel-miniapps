<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Authentication\IdentityInterface;

class AuthenticationHelper extends Helper
{
    /**
     * Get the authenticated identity object.
     */
    public function getIdentity(): ?IdentityInterface
    {
        return $this->getView()
            ->getRequest()
            ->getAttribute('identity');
    }

    /**
     * Check if a user is logged in.
     */
    public function isLoggedIn(): bool
    {
        return $this->getIdentity() !== null;
    }

    /**
     * Proxy getter for identity fields.
     *
     * Example:
     * $this->Authentication->get('email');
     */
    public function get(string $field, mixed $default = null): mixed
    {
        $identity = $this->getIdentity();

        if (!$identity) {
            return $default;
        }

        return $identity->get($field) ?? $default;
    }
}
