<?php

class Feedback extends Eloquent{

    protected $table = 'FEEDBACK';

    protected $timestamp = false;

    protected $fillable = [];

    public $timestamps = false;

    protected $dates = ['DATE'];

    protected $primaryKey = 'ID';

    public function user() {
        return $this->belongsTo('User', 'USER_ID', 'ID');
    }

}
