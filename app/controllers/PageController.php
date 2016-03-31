<?php

class PageController extends BaseController{

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function achievements()
    {
        $currentUser = User::find(Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        return Response::make(
            View::make('achievements.index')
                ->with('currentUser',       $currentUser)
                ->with('pageheadTitle',     'Achievements')
                ->with('breadCrumb',        ['Dashboard', 'Achievements'])
            , 200
        );
    }

    public function admins()
    {
        $currentUser = User::find(Session::get('UUID'));
        $adminList = User::where('ADMINLEVEL', '>', '0')->orderBy('ADMINLEVEL', 'desc')->with('adminlog')->take(50)->get(); //->remember(10)

        if(!$currentUser || !$adminList) {
            return App::abort('404');
        }

        $averageUptime = ceil(User::where('ADMINLEVEL', '>', '0')->avg(DB::raw('UPTIME - WEEKEND_UPTIME')));

        return Response::make(
            View::make('admin.list')
                ->with('currentUser',       $currentUser)
                ->with('adminList',         $adminList)
                ->with('totalAdmins',       $adminList->count())
                ->with('averageUptime',     $averageUptime)
                ->with('breadCrumb',        ['Dashboard', 'Admin List'])
                ->with('pageheadTitle',     'Admin List')
            , 200
        );
    }

    public function highscores()
    {
        $currentUser = User::find(Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        $sort = "";

        switch (Input::get("sort")) {
            case "asc":
                $sort .= "asc";
                break;
            case "desc":
                $sort .= "desc";
                break;
            default:
                $sort .= "desc";
                break;
        }

        $inputField = Input::get("field");
        $field = "";

        switch ($inputField) {
            case "name":
                $field .= "NAME";
                break;
            case "score":
                $field .= "SCORE";
                break;
            case "kills":
                $field .= "KILLS";
                break;
            case "deaths":
                $field .= "DEATHS";
                break;
            case "arrests":
                $field .= "ARRESTS";
                break;
            case "robbery":
                $field .= "ROBBERIES";
                break;
            case "fires":
                $field .= "FIRES";
                break;
            case "burglaries":
                $field .= "BURGLARIES";
                break;
            case "hits":
                $field .= "CONTRACTS";
                break;
            case "blownjails":
                $field .= "BLEW_JAILS";
                break;
            case "blownbank":
                $field .= "BLEW_VAULT";
                break;
            case "vehjacked":
                $field .= "VEHICLES_JACKED";
                break;
            case "meth":
                $field .= "METH_YIELDED";
                break;
            case "truck":
                $field .= "TRUCKED";
                break;
            default:
                $inputField = "score";
                $field .= "SCORE";
                break;
        }

        $players = User::orderBy( $field, $sort )->paginate(15);

        $currentSort = ($sort == "desc") ? "asc" : "desc";

        return Response::make(
            View::make('highscores.index')
                ->with('currentUser',       $currentUser)
                ->with( "players" ,         $players )
                ->with( "sort",             $currentSort )
                ->with( "field",            $inputField )
                ->with('breadCrumb',        ['Dashboard', 'Highscores'])
                ->with('pageheadTitle',     'Highscores')
            , 200
        );        
    }
}
