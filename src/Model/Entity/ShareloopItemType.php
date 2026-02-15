<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ShareloopItemType Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $icon
 * @property FrozenTime $created
 * @property \App\Model\Entity\ShareloopUserBook[] $shareloop_user_books
 */
class ShareloopItemType extends Entity
{
    /**
     * @var array<string>
     */
    protected array $_accessible = [
        'name' => true,
        'slug' => true,
        'description' => true,
        'icon' => true,
        'created' => true,
        'shareloop_user_books' => true,
    ];
}

