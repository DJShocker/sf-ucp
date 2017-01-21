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


    public function mappingTaxes()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ID < 6 && $currentUser->ID != 1) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        $today = \Carbon\Carbon::today();
        $yesterday = \Carbon\Carbon::yesterday();

        $mapTaxReceiptsDay = \MapTaxReceipts::where('DATE', '>', [$yesterday->toDateString(), $today->toDateString()])->get();
        $mapTaxReceiptsWeek = \MapTaxReceipts::with('user')->whereBetween('DATE', [$today->startOfWeek()->toDateString(), $today->endOfWeek()->toDateString()])->orderBy('DATE', 'DESC')->get();
        $mapTaxReceiptsMonth = \MapTaxReceipts::whereBetween('DATE', [$today->startOfMonth()->toDateString(), $today->endOfMonth()->toDateString()])->get();

        $mapTaxes = \MapTax::with('user')->whereRaw('`RENEWAL_TIMESTAMP` - UNIX_TIMESTAMP() < 2592000')->orderBy('RENEWAL_TIMESTAMP', 'ASC')->get();

        return \Response::make(
            \View::make('admin.taxes')
                ->with(compact('mapTaxes', 'mapTaxReceiptsDay', 'mapTaxReceiptsWeek', 'mapTaxReceiptsMonth'))
                ->with('currentUser',       $currentUser)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Mapping Taxes'])
                ->with('pageheadTitle',     'Mapping Taxes')
        , 200 );
    }
}
