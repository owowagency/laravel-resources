<?php

namespace owowagency\LaravelResources\Repositories;

use Carbon\Carbon;
use Dees040\Repository\Eloquent\BaseRepository as BaseRepositoryAbstract;
use owowagency\LaravelResources\Repositories\Contracts\BaseRepositoryContract;

abstract class BaseRepository extends BaseRepositoryAbstract implements BaseRepositoryContract
{
    /**
     * Check if record exists by multiple fields.
     *
     * @param  array  $where
     * @return bool
     */
    public function exists(array $where)
    {
        $exists = $this->model->where($where)->exists();

        return $exists;
    }

    /**
     * Touches record by multiple fields.
     *
     * @param  array  $where
     * @return void
     */
    public function touch(array $where)
    {
        $this->model->where($where)->update([
            'updated_at' => new Carbon
        ]);
    }
}
