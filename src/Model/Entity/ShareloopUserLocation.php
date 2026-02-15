<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ShareloopUserLocation Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property string|null $address
 * @property bool $is_default
 * @property FrozenTime $created
 * @property FrozenTime $modified
 * @property \App\Model\Entity\ShareloopUser $shareloop_user
 * @property \App\Model\Entity\ShareloopUserBook[] $shareloop_user_books
 */
class ShareloopUserLocation extends Entity
{
    /**
     * @var array<string>
     */
    protected array $_accessible = [
        'user_id' => true,
        'name' => true,
        'description' => true,
        'address' => true,
        'is_default' => true,
        'created' => true,
        'modified' => true,
        'shareloop_user' => true,
        'shareloop_user_books' => true,
    ];
}

