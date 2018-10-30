<?php

namespace OwowAgency\LaravelResources\Repositories\Contracts;

use dees040\repository\Contracts\Repository as RepositoryInterface;

interface BaseRepositoryContract extends RepositoryInterface
{
    /**
     * Check if record exists by multiple fields.
     *
     * @param  array  $where
     * @return bool
     */
    public function exists(array $where);

    /**
     * Touches record by multiple fields.
     *
     * @param  array  $where
     * @return void
     */
    public function touch(array $where);
}
