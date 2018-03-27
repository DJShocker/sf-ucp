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

    public function scopeGetTotalCash()
    {
        try {
            $query = \DB::select('SELECT USER_CASH, BIZ_CASH, GANG_CASH FROM (SELECT (SUM(BANKMONEY)+SUM(CASH)) USER_CASH FROM USERS) A CROSS JOIN (SELECT SUM(BANK) BIZ_CASH FROM BUSINESSES) B CROSS JOIN (SELECT SUM(BANK) GANG_CASH FROM GANGS) C');
            $total_cash = $query[0]->USER_CASH + $query[0]->BIZ_CASH + $query[0]->GANG_CASH;
        } catch (Exception $e) {
            $total_cash = null;
        }
        return $total_cash;
    }

}
