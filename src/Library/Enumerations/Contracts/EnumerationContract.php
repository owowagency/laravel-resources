<?php

namespace OwowAgency\LaravelResources\Library\Enumerations\Contracts;

interface EnumerationContract
{
    /**
     * Get the enumerations.
     *
     * @return array
     */
    public function getEnumerations();

    /**
     * Get the keys.
     *
     * @param  string|array  $values
     * @return array
     */
    public function getKeys($values = null);

    /**
     * Get key by value.
     *
     * @param  mixed  $value
     * @return string|bool
     */
    public function getKey($value);

    /**
     * Get the values.
     *
     * @return array
     */
    public function getValues();

    /**
     * Get value by a key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getValue($key);

    /**
     * Determine if the given key exists.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function keyExists($key);

    /**
     * Determine if the given value exists.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function valueExists($value);
}
