<?php namespace API;

use \Illuminate\Routing\Controller;
use \Dingo\Api\Routing\ControllerTrait;

class StockDataController extends \Controller {

    use ControllerTrait;

    public function stock($id)
    {
        if (ctype_digit($id) == false) {
            return \App::abort(403);
        }

        $stock_report = \StockReport::  select(
                                            \DB::raw('unix_timestamp(`REPORTING_TIME`) as DATE'),
                                            'PRICE', 'POOL AS EARNINGS'
                                        )
                                        ->where('STOCK_ID', '=', $id)
                                        ->where('PRICE', '!=', 0)
                                        ->orderBy('REPORTING_TIME', 'desc')
                                        ->orderBy('ID', 'desc')
                                        ->limit(30)
                                        ->get();


        if (!$stock_report) {
            return \App::abort('500');
        } else {
            return $stock_report;
        }
    }

}
