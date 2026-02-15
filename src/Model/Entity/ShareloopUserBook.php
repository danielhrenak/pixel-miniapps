<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ShareloopUserBook Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property int|null $location_id
 * @property int $item_type_id
 * @property string $condition
 * @property string|null $sharing_type
 * @property string|null $notes
 * @property string|null $qr_code
 * @property FrozenTime $created
 * @property FrozenTime $modified
 * @property \App\Model\Entity\ShareloopUser $shareloop_user
 * @property \App\Model\Entity\ShareloopBook $shareloop_book
 * @property \App\Model\Entity\ShareloopUserLocation|null $shareloop_user_location
 * @property \App\Model\Entity\ShareloopItemType $shareloop_item_type
 * @property \App\Model\Entity\ShareloopBookBorrowing[] $shareloop_book_borrowings
 */
class ShareloopUserBook extends Entity
{
    /**
     * @var array<string>
     */
    protected array $_accessible = [
        'user_id' => true,
        'book_id' => true,
        'location_id' => true,
        'item_type_id' => true,
        'condition' => true,
        'sharing_type' => true,
        'notes' => true,
        'qr_code' => true,
        'created' => true,
        'modified' => true,
        'shareloop_user' => true,
        'shareloop_book' => true,
        'shareloop_user_location' => true,
        'shareloop_item_type' => true,
        'shareloop_book_borrowings' => true,
    ];
}

