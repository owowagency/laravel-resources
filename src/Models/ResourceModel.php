<?php

namespace owowagency\LaravelResources\Models;

use Illuminate\Database\Eloquent\Model;
use owowagency\LaravelResources\Traits\HasResourceModelRelations;

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
