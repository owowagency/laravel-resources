<?php

namespace OwowAgency\LaravelResources\Managers;

use OwowAgency\LaravelResources\Managers\Contracts\Manageable;

abstract class BaseManager implements Manageable
{
    /**
     * The repository instance.
     *
     * @var \dees040\Repository\Eloquent\BaseRepository
     */
    protected $repository;

    /**
     * The model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Get the repository of a manager instance.
     *
     * @return \dees040\Repository\Contracts\Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Execute pagination on the repository.
     *
     * @param  array  $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($columns = ['*'])
    {
        return $this->repository->paginate(config('repository.pagination.limit', 15), $columns);
    }
}
