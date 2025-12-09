<?php

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property int $id
 * @property string $title
 * @property bool $comment_section_enabled
 * @property FrozenTime $created
 * @property FrozenTime $modified
 */
class Screen extends Entity
{

}
