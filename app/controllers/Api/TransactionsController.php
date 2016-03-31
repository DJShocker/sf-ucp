<?php namespace API;

use \Illuminate\Routing\Controller;
use \Dingo\Api\Routing\ControllerTrait;

class TransactionsController extends \Controller {

    public function __construct() {
        // Constructor
    }

    public function transactions()
    {
    	$recentTransact = \DB::table('TRANSACTIONS')
								->orderBy('DATE', 'desc')
								->select(
									\DB::raw('MD5(CONCAT(`DATE`, `CASH`)) as hash'),
									\DB::raw('FORMAT(CASH, 0) as cash'),
									'DATE as date'
								)
								->take(5)->get();

    	return $recentTransact;
    }

}
