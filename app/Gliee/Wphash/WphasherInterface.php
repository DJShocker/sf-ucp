<?php namespace Gliee\Wphash;

interface WphasherInterface {

    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    public function make($password, $salt, $pepper = '24713018', $cost = '2y');

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($password, $hashedValue, $salt, $pepper = '24713018', $cost = '2y');

}
