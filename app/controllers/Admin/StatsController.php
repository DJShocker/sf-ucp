<?php namespace Admin;

use BaseController;

class StatsController extends BaseController{

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('council');
    }

    public function index()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        $allNotes = \Notes::whereNull('DELETED')
                            ->where('NOTE', 'LIKE', '{FFDC2E}%')
                            ->orWhere(function($query) {
                                $query->whereNull('DELETED')->where('NOTE', 'LIKE', '{CD7F32}%');
                            })
                            ->has('user', 'author')
                            ->get();

        $registeredUsers = \User::count();
        $bannedUsers = \DB::table('BANS')->count();

        $totalCash = \User::select(\DB::raw('(SUM(`BANKMONEY`) + SUM(`CASH`)) as `TOTAL_CASH`'))->first()->TOTAL_CASH;
        $taxRate = \Server::taxrate()->first();
        $totalHouses = \DB::table('HOUSES')->count();
        $totalVehicles = \DB::table('VEHICLES')->count();
        $totalHouses = \DB::table('HOUSES')->count();
        $totalGates = \DB::table('GATES')->count();
        $totalApartments = \DB::table('APARTMENTS')->count();

        return \Response::make(
            \View::make('admin.stats')
                ->with('currentUser',       $currentUser)
                ->with('playerNotes',       $allNotes)
                ->with('totalCash',         $totalCash)
                ->with('registeredUsers',   $registeredUsers)
                ->with('taxRate',           $taxRate->FLOAT_VAL)
                ->with('totalHouses',       $totalHouses)
                ->with('totalVehicles',     $totalVehicles)
                ->with('bannedUsers',       $bannedUsers)
                ->with('totalGates',        $totalGates)
                ->with('totalApartments',   $totalApartments)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Server Statistics'])
                ->with('pageheadTitle',     'Server Statistics')
        , 200 );
    }
}
