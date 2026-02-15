<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShareloopUserLocations Table
 *
 * @method \App\Model\Entity\ShareloopUserLocation newEmptyEntity()
 * @method \App\Model\Entity\ShareloopUserLocation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserLocation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserLocation get(mixed $primaryKey, array $options = [])
 * @method \App\Model\Entity\ShareloopUserLocation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserLocation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserLocation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class ShareloopUserLocationsTable extends Table
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

        $this->setTable('shareloop_user_locations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShareloopUsers', [
            'foreignKey' => 'user_id',
            'className' => 'ShareloopUsers',
        ]);
        $this->hasMany('ShareloopUserBooks', [
            'foreignKey' => 'location_id',
            'className' => 'ShareloopUserBooks',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('address')
            ->maxLength('address', 500)
            ->allowEmptyString('address');

        $validator
            ->boolean('is_default')
            ->notEmptyString('is_default');

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
        $rules->add($rules->existsIn(['user_id'], 'ShareloopUsers'), ['errorField' => 'user_id']);

        return $rules;
    }
}

