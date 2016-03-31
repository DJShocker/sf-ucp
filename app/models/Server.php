<?php

class Server extends Eloquent{

    protected $table = 'SERVER';

    protected $timestamp = false;

    protected $fillable = [];

    /*
     * Returns Tax Rate
    */
    public function scopeTaxrate($query)
    {
        return $query->where('NAME', '=', 'taxrate');
    }

    /*
     * Returns Director ID
    */
    public function scopeDirector($query)
    {
        return $query->where('NAME', '=', 'director');
    }

}
