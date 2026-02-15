<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShareloopUsers Table
 *
 * @method \App\Model\Entity\ShareloopUser newEmptyEntity()
 * @method \App\Model\Entity\ShareloopUser newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUser get(mixed $primaryKey, array $options = [])
 * @method \App\Model\Entity\ShareloopUser findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ShareloopUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUser[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUser|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ShareloopUser saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ShareloopUser> saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ShareloopUser> saveManyOrFail(iterable $entities, array $options = [])
 */
class ShareloopUsersTable extends Table
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

        $this->setTable('shareloop_users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ShareloopUserVerifications', [
            'foreignKey' => 'user_id',
            'className' => 'ShareloopUserVerifications',
        ]);
        $this->hasMany('ShareloopUserLocations', [
            'foreignKey' => 'user_id',
            'className' => 'ShareloopUserLocations',
        ]);
        $this->hasMany('ShareloopUserBooks', [
            'foreignKey' => 'user_id',
            'className' => 'ShareloopUserBooks',
        ]);
        $this->hasMany('ShareloopBookBorrowings', [
            'foreignKey' => 'borrower_id',
            'className' => 'ShareloopBookBorrowings',
        ]);
        $this->hasMany('ShareloopReadingLists', [
            'foreignKey' => 'user_id',
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
            ->scalar('email')
            ->maxLength('email', 255)
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password_hash')
            ->allowEmptyString('password_hash');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->allowEmptyString('last_name');

        $validator
            ->boolean('verified')
            ->notEmptyString('verified');

        $validator
            ->boolean('active')
            ->notEmptyString('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}

