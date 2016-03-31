<?php namespace Gliee\Wphash;

class WPhash implements WphasherInterface {

    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    public function make($password, $salt, $pepper = '24713018', $cost = '2y')
    {
        return strtoupper(hash('whirlpool', $salt.$pepper.strtoupper(hash('whirlpool', $password)).'$'.$cost.'$'));
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($password, $hashedValue, $salt, $pepper = '24713018', $cost = '2y')
    {
        return ( strtoupper(hash('whirlpool', $salt.$pepper.strtoupper(hash('whirlpool', $password)).'$'.$cost.'$')) == $hashedValue) ? true : false;
    }

}
