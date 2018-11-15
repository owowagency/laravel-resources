<?php

namespace OwowAgency\LaravelResources\Routing;

use Dingo\Api\Routing\ResourceRegistrar as DingoResourceRegistrar;

class ResourceRegistrar extends DingoResourceRegistrar
{
    /**
     * Get the action array for a resource route.
     *
     * @param  string  $resource
     * @param  string  $controller
     * @param  string  $method
     * @param  array  $options
     * @return array
     */
    protected function getResourceAction($resource, $controller, $method, $options)
    {
        $action = parent::getResourceAction($resource, $controller, $method, $options);

        if (isset($options['model'])) {
            $action['model'] = $options['model'];
        }

        if (isset($options['requests'])) {
            $action['requests'] = $options['requests'];
        }

        return $action;
    }
}
