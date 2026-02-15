<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * ShareloopBook Entity
 *
 * @property int $id
 * @property string|null $isbn
 * @property string $title
 * @property string|null $author
 * @property string|null $publisher
 * @property int|null $published_year
 * @property string|null $description
 * @property string|null $cover_image_url
 * @property int|null $pages
 * @property string $language
 * @property FrozenTime $created
 * @property FrozenTime $modified
 * @property \App\Model\Entity\ShareloopUserBook[] $shareloop_user_books
 * @property \App\Model\Entity\ShareloopReadingList[] $shareloop_reading_lists
 */
class ShareloopBook extends Entity
{
    /**
     * @var array<string>
     */
    protected array $_accessible = [
        'isbn' => true,
        'title' => true,
        'author' => true,
        'publisher' => true,
        'published_year' => true,
        'description' => true,
        'cover_image_url' => true,
        'pages' => true,
        'language' => true,
        'created' => true,
        'modified' => true,
        'shareloop_user_books' => true,
        'shareloop_reading_lists' => true,
    ];
}

