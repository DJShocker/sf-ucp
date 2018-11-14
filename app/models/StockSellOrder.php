<?php

use \Carbon\Carbon;

class StockSellOrder extends Eloquent{

    protected $table = 'STOCK_SELL_ORDERS';

    protected $primaryKey = ['STOCK_ID', 'USER_ID'];

    public $timestamps = false;



}
