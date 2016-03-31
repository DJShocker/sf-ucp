<?php

use Carbon\Carbon;

class DashboardController extends BaseController{

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

        $serverVariables = Server::taxrate()->first();

        $numberGarages = DB::table('GARAGES')->where('OWNER', '=', $currentUser->ID)->count('ID');

        $serverPlayers = User::where('ONLINE', '>=', 1)->count('ID');

        return Response::make(
            View::make('dashboard.index')
                ->with('currentUser',       $currentUser)
                ->with('numberGarages',     $numberGarages)
                ->with('serverPlayers',     $serverPlayers)
                ->with('taxRate',           sprintf("%.1f", $serverVariables->FLOAT_VAL))
                ->with('vipExpiry',         Carbon::createFromTimeStamp($currentUser->VIP_EXPIRE)->diffForHumans())
                ->with('vipExpiryFull',     Carbon::createFromTimeStamp($currentUser->VIP_EXPIRE)->toDayDateTimeString())
                ->with('timeOnline',        \Gliee\Irresistible\Utils::secondstohuman($currentUser->UPTIME))
                ->with('timeOnlineWeekly',  \Gliee\Irresistible\Utils::secondstohuman($currentUser->UPTIME - $currentUser->WEEKEND_UPTIME))
                ->with('mutedTime',         $currentUser->MUTE_TIME > time() ? Carbon::createFromTimeStamp($currentUser->MUTE_TIME)->diffForHumans() : null)
                ->with('jailedTime',        $currentUser->JAIL_TIME ? \Gliee\Irresistible\Utils::secondstohuman($currentUser->JAIL_TIME) : null)
                ->with('kdRatio',           sprintf("%.2f", $currentUser->KILLS / $currentUser->DEATHS))
                ->with('breadCrumb',        ['Dashboard'])
                ->with('pageheadTitle',     'Dashboard')
            , 200
        );
    }
}
