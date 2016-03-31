<?php

class Help extends Eloquent{

    protected $table = 'HELP';

    protected $timestamp = false;

    protected $fillable = [];

    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo('User', 'USER_ID', 'ID');
    }
}
