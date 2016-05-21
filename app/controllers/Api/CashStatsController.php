<?php namespace API;

use \Illuminate\Routing\Controller;
use \Dingo\Api\Routing\ControllerTrait;

class CashStatsController extends \Controller {

    use ControllerTrait;
    public function __construct() {
        // Constructor
    }

    public function totalcash()
    {
	 	$totalCash = \DB::table('STATS')->where('NAME', '=', 'totalcash')
	 								   ->select(
	 								   		\DB::raw('unix_timestamp(`CREATED_AT`) as date'),
	 								   		'INT_VAL as cash'
	 								   	)
	 								   	->orderBy('CREATED_AT', 'desc')->limit(7)->remember(10)->get();

        if(!$totalCash)
            return \App::abort('500');

	    return $totalCash;
    }

    public function create($apiKey)
    {
    	if($apiKey != \Config::get('irresistible.api_key')){
            return \App::abort('403');
    	}

        $totalCash = \User::select(\DB::raw('(SUM(`BANKMONEY`) + SUM(`CASH`)) as `TOTAL_CASH`'))->first();

        if(is_null($totalCash))
        	return \App::abort('500');

        try
        {
	        $entry 			= new \Stats;
	        $entry->NAME 	= 'totalcash';
	        $entry->INT_VAL = $totalCash->TOTAL_CASH;
	 		$entry->save();

            return \Response::json(["message" => "A new entry has been successfully implemented."]);
        }
        catch(Exception $e)
        {
        	return \App::abort('500');
        }
    }

    public function donorReset($apiKey)
    {
        if($apiKey != \Config::get('irresistible.api_key')){
            return \App::abort('403');
        }

        try
        {
            \DB::statement('TRUNCATE TABLE `TOP_DONOR`');
            return "Truncated donor statistics.";
        }
        catch(Exception $e)
        {
            return \App::abort('500');
        }
    }
}
