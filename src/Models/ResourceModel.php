<?php

namespace OwowAgency\LaravelResources\Models;

use Illuminate\Database\Eloquent\Model;
use OwowAgency\LaravelResources\Concerns\HasResourceModelRelations;

class ResourceModel extends Model
{
    use HasResourceModelRelations;

    /**
     * Returns the resource representation of this model.
     *
     * @return array
     */
    public function toResource()
    {
        return resource($this);
    }
}
