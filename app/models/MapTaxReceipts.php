<?php

class MapTaxReceipts extends Eloquent{

    protected $table = 'MAP_TAX_RECEIPTS';

    public $timestamps = false;

    protected $dates = ['DATE'];

    protected $primaryKey = 'ID';

    public function user() {
        return $this->belongsTo('User', 'USER_ID', 'ID');
    }

    public function renewed() {
    	return $this->DATE->diffForHumans();
    }
}
