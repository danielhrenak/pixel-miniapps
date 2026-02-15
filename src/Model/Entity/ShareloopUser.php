<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ShareloopUser Entity
 *
 * @property int $id
 * @property string $email
 * @property string|null $password_hash
 * @property string|null $first_name
 * @property string|null $last_name
 * @property bool $verified
 * @property bool $active
 * @property FrozenTime $created
 * @property FrozenTime $modified
 * @property \App\Model\Entity\ShareloopUserVerification[] $shareloop_user_verifications
 * @property \App\Model\Entity\ShareloopUserLocation[] $shareloop_user_locations
 * @property \App\Model\Entity\ShareloopUserBook[] $shareloop_user_books
 * @property \App\Model\Entity\ShareloopBookBorrowing[] $shareloop_book_borrowings
 * @property \App\Model\Entity\ShareloopReadingList[] $shareloop_reading_lists
 */
class ShareloopUser extends Entity
{
    /**
     * @var array<string>
     */
    protected array $_accessible = [
        'email' => true,
        'password_hash' => true,
        'first_name' => true,
        'last_name' => true,
        'verified' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'shareloop_user_verifications' => true,
        'shareloop_user_locations' => true,
        'shareloop_user_books' => true,
        'shareloop_book_borrowings' => true,
        'shareloop_reading_lists' => true,
    ];

    /**
     * @var array<string>
     */
    protected array $_hidden = [
        'password_hash',
    ];
}

