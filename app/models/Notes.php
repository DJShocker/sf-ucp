<?php

class Notes extends Eloquent{

    protected $table = 'NOTES';

    protected $timestamp = false;

    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('User', 'USER_ID', 'ID');
    }

    public function author()
    {
        return $this->belongsTo('User', 'ADDED_BY', 'ID');
    }
}
