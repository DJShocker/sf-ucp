<?php

class StocksController extends BaseController{

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

        $stockReports = StockReport::where('PRICE', '=', 0)->get();

      	return Response::make(
            View::make('stocks.index')
       			->with('currentUser', 		$currentUser)

                ->with('stockReports',      $stockReports)
                ->with('breadCrumb',        ['Dashboard', 'Stocks'])
                ->with('pageheadTitle',     'Stocks')
            , 200
        );
    }
}
