<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ShareloopReadingList Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property int $priority
 * @property string $status
 * @property FrozenTime $created
 * @property FrozenTime $modified
 * @property \App\Model\Entity\ShareloopUser $shareloop_user
 * @property \App\Model\Entity\ShareloopBook $shareloop_book
 */
class ShareloopReadingList extends Entity
{
    /**
     * @var array<string>
     */
    protected array $_accessible = [
        'user_id' => true,
        'book_id' => true,
        'priority' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'shareloop_user' => true,
        'shareloop_book' => true,
    ];
}

