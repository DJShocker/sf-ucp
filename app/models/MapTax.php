<?php

class MapTax extends Eloquent{

    protected $table = 'MAP_TAX';

    public $timestamps = false;

    public function user() {
        return $this->belongsTo('User', 'USER_ID', 'ID');
    }

    public function expiry()
    {
    	return \Carbon\Carbon::createFromTimestamp($this->RENEWAL_TIMESTAMP)->diffForHumans();
    }
}
