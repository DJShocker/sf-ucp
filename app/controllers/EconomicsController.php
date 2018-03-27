<?php

class EconomicsController extends BaseController{

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function index()
    {
        $currentUser = User::find(Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        // Server Variables
        $totalCash = Server::getTotalCash();
        $taxRate = Server::taxrate()->first();


        if(!$totalCash || !$taxRate) {
            return App::abort('404');
        }

        // Total assets (vehicle/houses)
        $totalHouses = DB::table('HOUSES')->count();
        $totalVehicles = DB::table('VEHICLES')->count();

        // Totals up historical costs of houses, vehicles and apartments atm.
        $userCapital = (
        	DB::table('VEHICLES')->where('OWNER', '=', $currentUser->NAME)->sum('PRICE') +
        	DB::table('HOUSES')->where('OWNER', '=', $currentUser->NAME)->sum('COST') +
        	DB::table('APARTMENTS')->where('OWNER', '=', $currentUser->NAME)->count() * 5000000
     	);

     	// Total Increase Percentage
        $percentageRows = Stats::where('NAME', '=', 'totalcash')->select('INT_VAL as cash', 'CREATED_AT', 'NAME')
	 								   							->orderBy('CREATED_AT', 'desc')->limit(1)->get(); // Get two most recent

        $difference = $totalCash - $percentageRows[0]->cash;


		$percentage = ($percentageRows[0]->cash < $totalCash ? '+' : '') . sprintf("%.1f", ($difference / $totalCash) * 100);

      	return Response::make(
            View::make('economics.index')
       			->with('currentUser', 		$currentUser)
                ->with('totalCash',			$totalCash)
                ->with('netWorth',			$currentUser->CASH + $currentUser->BANKMONEY + $userCapital)
                ->with('userCapital',		$userCapital)
                ->with('totalHouses',		$totalHouses)
                ->with('totalVehicles',		$totalVehicles)
                ->with('increasePercent',	$percentage)
                ->with('taxRate',           sprintf("%.1f", $taxRate->FLOAT_VAL))
                ->with('breadCrumb',        ['Dashboard', 'Economics'])
                ->with('pageheadTitle',     'Economics')
            , 200
        );
    }
}
