<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShareloopBooks Table
 *
 * @method \App\Model\Entity\ShareloopBook newEmptyEntity()
 * @method \App\Model\Entity\ShareloopBook newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopBook[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopBook get(mixed $primaryKey, array $options = [])
 * @method \App\Model\Entity\ShareloopBook patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopBook[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopBook|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class ShareloopBooksTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('shareloop_books');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ShareloopUserBooks', [
            'foreignKey' => 'book_id',
            'className' => 'ShareloopUserBooks',
        ]);
        $this->hasMany('ShareloopReadingLists', [
            'foreignKey' => 'book_id',
            'className' => 'ShareloopReadingLists',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('isbn')
            ->maxLength('isbn', 20)
            ->allowEmptyString('isbn')
            ->add('isbn', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'allowMultipleNulls' => true]);

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('author')
            ->maxLength('author', 255)
            ->allowEmptyString('author');

        $validator
            ->scalar('publisher')
            ->maxLength('publisher', 255)
            ->allowEmptyString('publisher');

        $validator
            ->integer('published_year')
            ->allowEmptyString('published_year');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('cover_image_url')
            ->maxLength('cover_image_url', 500)
            ->allowEmptyString('cover_image_url');

        $validator
            ->integer('pages')
            ->allowEmptyString('pages');

        $validator
            ->scalar('language')
            ->maxLength('language', 10)
            ->notEmptyString('language');

        return $validator;
    }
}

