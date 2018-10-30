<?php

namespace owowagency\LaravelResources\Managers\Contracts;

interface Manageable
{
    /**
     * Get the repository of a manager instance.
     *
     * @return \dees040\Repository\Contracts\Repository
     */
    public function getRepository();

    /**
     * Execute a dynamic pagination on the repository.
     *
     * @param  array  $columns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($columns = ['*']);
}
