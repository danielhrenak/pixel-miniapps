<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ShareloopUserVerification Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $token_type
 * @property FrozenTime|null $expires_at
 * @property bool $used
 * @property FrozenTime $created
 * @property \App\Model\Entity\ShareloopUser $shareloop_user
 */
class ShareloopUserVerification extends Entity
{
    /**
     * @var array<string>
     */
    protected array $_accessible = [
        'user_id' => true,
        'token' => true,
        'token_type' => true,
        'expires_at' => true,
        'used' => true,
        'created' => true,
        'shareloop_user' => true,
    ];
}

