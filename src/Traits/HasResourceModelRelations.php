<?php

namespace OwowAgency\LaravelResources\Traits;

trait HasResourceModelRelations
{
    /**
     * The relations of this model
     * 
     * @var array
     */ 
    public $definedRelations = [];

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (array_key_exists($method, $this->definedRelations)) {
            $value = $this->getDefinedRelationValue($method);

            if ($value !== false) {
                return $value;
            }
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Handle a call to a defined relation.
     *
     * @param  string  $method
     * @return mixed
     */
    private function getDefinedRelationValue($method)
    {
        $relation = $this->definedRelations[$method];

        $relation['method'] = $method;

        $type = $relation['type'];

        $relationMethod = $this->getDefinedRelationMethod($type);

        if ($relationMethod === false) {
            return false;
        }

        return $this->$relationMethod($relation);
    }

    /**
     * Gets HasOneRelation value.
     * 
     * @param  array  $relation
     * @return mixed
     */
    private function getHasOneRelationValue($relation)
    {
        $attributes = data_get_multiple($relation,[
            'type', 'model', 'foreignKey', 'localKey'
        ]);

        list($type, $model, $foreignKey, $localKey) = $attributes;

        return $this->$type($model, $foreignKey, $localKey);
    }

    /**
     * Gets BelongsToManyRelation value.
     * 
     * @param  array  $relation
     * @return mixed
     */
    private function getBelongsToManyRelationValue($relation)
    {
        $attributes = data_get_multiple($relation,[
            'type', 'model', 'table', 'foreignPivotKey', 'relatedPivotKey', 'withPivot'
        ]);

        list($type, $model, $table, $foreignPivotKey, $relatedPivotKey, $withPivot) = $attributes;

        $belongsToMany = $this->$type($model, $table, $foreignPivotKey, $relatedPivotKey);

        if (! is_null($withPivot)) {
            $belongsToMany->withPivot($withPivot);
        }

        return $belongsToMany;
    }

    /**
     * Gets MorphManyRelation value.
     * 
     * @param  array  $relation
     * @return mixed
     */
    private function getMorphManyRelationValue($relation)
    {
        $attributes = data_get_multiple($relation,[
            'type', 'model', 'name', 'typeKey', 'idKey', 'localKey'
        ]);

        list($type, $model, $name, $typeKey, $idKey, $localKey) = $attributes;

        $name = $name ?? $relation['method'];

        return $this->$type($model, $name, $typeKey, $idKey, $localKey);
    }

    /**
     * Gets MorphToRelation value.
     * 
     * @param  array  $relation
     * @return mixed
     */
    private function getMorphToRelationValue($relation)
    {
        $attributes = data_get_multiple($relation,[
            'type', 'name', 'typeKey', 'idKey', 'ownerKey'
        ]);

        list($type, $name, $typeKey, $idKey, $ownerKey) = $attributes;

        $name = $name ?? $relation['method'];

        return $this->$type($name, $typeKey, $idKey, $ownerKey);
    }


    /**
     * Gets the defined relation method by type.
     * 
     * @param  string  $type
     * @return string
     */
    private function getDefinedRelationMethod($type)
    {
        $methods = [
            'getHasOneRelationValue' => [
                'hasOne', 'hasMany', 'belongsTo'
            ],
            'getBelongsToManyRelationValue' => [
                'belongsToMany'
            ],
            'getMorphManyRelationValue' => [
                'morphMany'
            ],
            'getMorphToRelationValue' => [
                'morphTo'
            ]
        ];

        $matches = array_where($methods, function ($value, $key) use ($type) {
            return in_array($type, $value);
        });

        if (empty($matches)) {
            return false;
        }

        return array_keys($matches)[0];
    }

    /**
     * Get a relationship.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getRelationValue($key)
    {
        if (array_key_exists($key, $this->definedRelations)) {
            return $this->$key()->getResults();
        }

        return parent::getRelationValue($key);;
    }
}
