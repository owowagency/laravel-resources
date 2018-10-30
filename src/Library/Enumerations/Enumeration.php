<?php

namespace owowagency\LaravelResources\Library\Enumerations;

use owowagency\LaravelResources\Library\Enumerations\Contracts\EnumerationContract;

class Enumeration implements EnumerationContract
{
    /**
     * The key value pairs.
     *
     * @var array
     */
    protected $enumerations = [];

    /**
     * Get the enumerations.
     *
     * @return array
     */
    public function getEnumerations()
    {
        return $this->enumerations;
    }

    /**
     * Get the keys.
     *
     * @param  string|array  $values
     * @return array
     */
    public function getKeys($values = null)
    {
        if (is_null($values)) {
            return array_keys($this->enumerations);
        }

        $keys = [];
        $values = is_string($values)
            ? explode(',', $values)
            : (array) $values;

        foreach ($values as $value) {
            $key = $this->getKey($value);

            if ($key !== false) {
                $keys[] = $key;
            }
        }

        return $keys;
    }

    /**
     * Get key by value.
     *
     * @param  mixed  $value
     * @return string|bool
     */
    public function getKey($value)
    {
        return array_search($value, $this->enumerations);
    }

    /**
     * Get the values.
     *
     * @return array
     */
    public function getValues()
    {
        return array_values($this->enumerations);
    }

    /**
     * Get value by a key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getValue($key)
    {
        return data_get($this->enumerations, $key, null);
    }

    /**
     * Determine if the given key exists.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function keyExists($key)
    {
        return array_key_exists($key, $this->enumerations);
    }

    /**
     * Determine if the given value exists.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function valueExists($value)
    {
        return $this->getKey($value) !== false;
    }
}
