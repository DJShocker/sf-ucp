<?php

class Coins extends Eloquent{

    protected $table = 'TRANSACTIONS_IC';

    protected $timestamp = false;

    protected $fillable = [];

    public $timestamps = false;

    public function toUser() {
    	return $this->belongsTo('User', 'TO_ID', 'ID');
    }

    public function fromUser() {
    	return $this->belongsTo('User', 'FROM_ID', 'ID');
    }
}
