<?php

use \Carbon\Carbon;

class StockOwner extends Eloquent{

    protected $table = 'STOCK_OWNERS';

    protected $primaryKey = ['STOCK_ID', 'USER_ID'];

    public $timestamps = false;

}
