<?php

return [

    /**
     * Is used for auto discovery of http resources. Allows for placing
     * resources under a different namespace.
     */
    'resource_namespace' => 'App\\Http\\Resources',

    /**
     * Configure resources that do not follow the default auto discovery rules.
     *
     * Eg:
     * [Post::class => SpecialPostResource::class]
     */
    'resource_factory' => [],

];
