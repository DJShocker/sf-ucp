<?php

use \Carbon\Carbon;

class Stocks extends Eloquent{

    //protected $table = 'CROWDFUNDS';

    //protected $primaryKey = 'ID';

    //public $timestamps = false;

    public static $stockData =
    [
        ["NAME" => "The Mining Company", "TICKER" => "MC"],
        ["NAME" => "Ammu-Nation", "TICKER" => "A"],
        ["NAME" => "Vehicle Dealership", "TICKER" => "VD"],
        ["NAME" => "Supa-Save", "TICKER" => "SS"],
        ["NAME" => "The Trucking Company", "TICKER" => "TC"],
        ["NAME" => "Cluckin' Bell", "TICKER" => "CB"],
        ["NAME" => "Pawn Store", "TICKER" => "PS"],
        ["NAME" => "Casino", "TICKER" => "CAS"],
        ["NAME" => "Government", "TICKER" => "GOV"],
        ["NAME" => "Elitas Travel", "TICKER" => "ET"]
    ];

    public static function getMaxShares($id)
    {
        $owners = StockOwner::where('STOCK_ID', '=', $id)->sum('SHARES');
        $sellorders = StockSellOrder::where('STOCK_ID', '=', $id)->sum('SHARES');
        return $owners + $sellorders;
    }

    public static function getReport($id, $skip, $limit)
    {
        return StockReport::where('STOCK_ID', '=', $id)->orderBy('REPORTING_TIME', 'desc')->orderBy('ID', 'desc')->skip($skip)->limit($limit)->get();
    }
}
