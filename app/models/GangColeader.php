<?php

class GangColeader extends Eloquent{

    protected $table = 'GANG_COLEADERS';

    public $timestamps = false;

    public function gang() {
        return $this->belongsTo('Gang', 'GANG_ID', 'ID');
    }

    public function color() {
    	return substr("00000000".dechex($this->COLOR),-8, -2);
    }
}
