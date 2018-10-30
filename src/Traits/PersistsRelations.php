<?php

namespace owowagency\LaravelResources\Traits;

trait PersistsRelations
{
    /**
     * Persists relations.
     * Loops through the by model defined relations.
     * Checks if relation is present in data.
     * Calls correct method depending on relation type.
     * 
     * @param  mixed  $resourceModel
     * @param  array  $data
     * @return void
     */
    private function persistRelations($resourceModel, $data)
    {
        foreach ($resourceModel->definedRelations as $key => $relation) {
            $snakeKey = snake_case($key);

            if (! array_key_exists($snakeKey, $data)) continue;

            $method = 'persist' . ucfirst($relation['type']);

            $relationData = $data[$snakeKey];

            $this->$method($resourceModel, array_merge(['name' => $key], $relation), $relationData);
        }
    }

    /**
     * Persists has one relations.
     * 
     * @param  mixed  $resourceModel
     * @param  array  $relation
     * @param  array  $data
     * @return void
     */
    private function persistHasOne($resourceModel, $relation, $data)
    {
        $resourceManager = manager($relation['model']);

        $foreignKeyName = $relation['foreignKey'] ?? snake_case(class_basename($resourceModel)) . '_id';

        $data[$foreignKeyName] = $resourceModel->id;

        $relatedResourceModel = $resourceManager->create($data);
    }

    /**
     * Persists has many relations.
     * 
     * @param  mixed  $resourceModel
     * @param  array  $relation
     * @param  array  $items
     * @return void
     */
    private function persistHasMany($resourceModel, $relation, $items)
    {
        foreach ($items as $data) {
            $this->persistHasOne($resourceModel, $relation, $data);
        }
    }

    /**
     * Persists morph manu relations.
     * 
     * @param  mixed  $resourceModel
     * @param  array  $relation
     * @param  array  $items
     * @return void
     * TODO fix persistMorphMany
     */
//    private function persistMorphMany($resourceModel, $relation, $items)
//    {
//        foreach ($items as $data) {
//            $relation['foreignKey'] = 'eventable_id';
//            $data['eventable_type'] = (new ModelStringNamespaceMappings)->getKey(get_class($resourceModel));
//
//            $this->persistHasOne($resourceModel, $relation, $data);
//        }
//    }

    /**
     * Persists belongs to many relations.
     * Can handle assoc array with data to create a new record.
     * Can handle an integer to attach an existing record.
     * 
     * @param  mixed  $resourceModel
     * @param  array  $relation
     * @param  array  $items
     * @return void
     */
    private function persistBelongsToMany($resourceModel, $relation, $items)
    {
        $relatedModelIds = [];

        foreach ($items as $data) {
            $resourceManager = manager($relation['model']);

            $pivotData = $data['pivot'] ?? [];

            unset($data['pivot']);

            if (is_array($data)) {
                if (array_key_exists('id', $data)) {
                    $relatedModelIds[$data['id']] = $pivotData;
                } else {
                    $createMethod = data_get($relation, 'unique') ? 'create' : 'firstOrCreate';

                    $relatedResourceModel = $resourceManager->$createMethod($data);

                    $relatedModelIds[$relatedResourceModel->id] = $pivotData;
                }
            } else if (is_numeric($data)) {
                $relatedModelIds[$data] = $pivotData;
            }
        }

        $resourceModel->{$relation['name']}()->sync($relatedModelIds);
    }
}
