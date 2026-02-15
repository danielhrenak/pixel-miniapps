<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ShareloopBookBorrowing Entity
 *
 * @property int $id
 * @property int $user_book_id
 * @property int $borrower_id
 * @property FrozenTime $borrowed_at
 * @property FrozenTime|null $due_date
 * @property FrozenTime|null $returned_at
 * @property string $status
 * @property string|null $notes
 * @property FrozenTime $created
 * @property FrozenTime $modified
 * @property \App\Model\Entity\ShareloopUserBook $shareloop_user_book
 * @property \App\Model\Entity\ShareloopUser $shareloop_user
 */
class ShareloopBookBorrowing extends Entity
{
    /**
     * @var array<string>
     */
    protected array $_accessible = [
        'user_book_id' => true,
        'borrower_id' => true,
        'borrowed_at' => true,
        'due_date' => true,
        'returned_at' => true,
        'status' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'shareloop_user_book' => true,
        'shareloop_user' => true,
    ];
}

