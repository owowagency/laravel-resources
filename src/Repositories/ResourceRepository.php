<?php

namespace owowagency\LaravelResources\Repositories;

use owowagency\LaravelResources\Traits\PersistsRelations;
use owowagency\LaravelResources\Repositories\Contracts\ResourceRepositoryContract;

class ResourceRepository extends BaseRepository implements ResourceRepositoryContract
{
    use PersistsRelations;
    
    /**
     * The resource model class.
     *
     * @var string
     */
    private $resourceModelClass;

    /**
     * ResourceRepository constructor.
     *
     * @param  string  $resourceModelClass
     * @return void
     */
    public function __construct($resourceModelClass)
    {
        $this->resourceModelClass = $resourceModelClass;

        parent::__construct();
    }

    /**
     * Get the base model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->resourceModelClass;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes = [])
    {
        $fillable = $this->model->getFillable();

        $resourceModel = parent::create(array_only($attributes, $fillable));

        $this->persistRelations($resourceModel, $attributes);

        return $resourceModel;
    }

    // TODO update persist relations
}



