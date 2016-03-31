<?php namespace Admin;

use BaseController;

class AdminController extends BaseController{

    static $searchRules = [
        "table" 	=>  "required",
        "name"  	=>  "min:2|max:24",
        "ip"  		=>  "max:16",
        "score-min" =>  "numeric",
        "score-max" =>  "numeric",
        "cash-min" 	=>  "numeric",
        "cash-max" 	=>  "numeric",
        "recent" 	=> 	"boolean"
    ];

    static $searchTransactionRules = [
        "searchType" =>  "required|integer|between:0,1",
        "toName"     =>  "string|min:2|max:24|exists:USERS,NAME",
        "fromName"   =>  "string|min:2|max:24|exists:USERS,NAME"
    ];

    static $banRules = [
        "name"  =>  "required|unique:BANS,NAME",
        "reason" => "max:32"
    ];

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('admin');
    }

    public function index()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        if($currentUser->ADMINLEVEL < \Config::get('irresistible.search'))
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);

        $field = "";
        $sort = "";

        switch (\Input::get("sort")) {
            case "asc":
                $sort .= "asc";
                break;
            case "desc":
                $sort .= "desc";
                break;
            default:
                $sort .= "asc";
                break;
        }

        switch (\Input::get("field")) {
            case "name":
                $field .= "NAME";
                break;
            case "ip":
                $field .= "IP";
                break;
            case "score":
                $field .= "SCORE";
                break;
            case "cash":
                $field .= "CASH";
                break;
            case "bankcash":
                $field .= "BANKMONEY";
                break;
            case "xp":
                $field .= "XP";
                break;
            case "adminlevel":
                $field .= "ADMINLEVEL";
                break;
            case "lastip":
                $field .= "LAST_IP";
                break;
            case "bounty":
                $field .= "BOUNTY";
                break;
            default:
                $field .= "NAME";
                break;
        }

        $users = \User::orderBy( $field, $sort )->paginate(15);

        $currentSort = ($sort == "desc") ? "asc" : "desc";

        return \Response::make(
            \View::make('admin.index')
            	->with('currentUser',		$currentUser)
                ->with('users', 			$users)
                ->with('sort', 				$currentSort)
                ->with('field', 			$field)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Search User'])
                ->with('pageheadTitle',     'Search User')
        , 200 );
    }

	public function search()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        if($currentUser->ADMINLEVEL < \Config::get('irresistible.search'))
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);

      	$validation = \Validator::make(\Input::all(), static::$searchRules);

        if($validation->fails())
        {
          	return \Redirect::to('/admin/search')->withErrors($validation);
        }

        $userName  	 = trim(htmlentities(\Input::get("name")));
        $ipAddress 	 = trim(htmlentities(\Input::get("ip")));
        $recentOrder = \Input::has('recent') ? 1 : 0;
        $table 		 = \Input::get('table');

        $score = [
        	"min" => \Input::get('score-min'),
        	"max" => \Input::get('score-max')
        ];

        $cash = [ 
        	"min" => \Input::get('cash-min'), 
        	"max" => \Input::get('cash-max')
        ];

        $tableSelection = "";

        switch($table) {
            case 1:
                $tableSelection .= 'BANS';
                break;
            default:
                $tableSelection .= 'USERS';
                break;
        }

        if(\Input::has('name') && \Input::has('ip'))
        {
          	return \Redirect::to('/admin/search')->withErrors(['One name or IP is required only for a query. Not both.']);
        }


      	$query = \DB::table($tableSelection);

        if( \Input::has("ip") ) $query = $query->where( "IP", "LIKE", trim( strip_tags( $ipAddress ) )."%" );
        else
        {
    	   //if(!empty($userName))
           	$query->where( "NAME", "LIKE", "%".trim( strip_tags( $userName ) )."%" );
                    
            // Only for USERS
            if(!$table) 
            {
                if(!empty($score['min']))
                    $query = $query->having('SCORE', '>', $score['min']);

                if(!empty($score['max']))
                    $query = $query->having('SCORE', '<', $score['max']);

                if(!empty($cash['min']))
                    $query = $query->having('CASH', '>', $cash['min']);

                if(!empty($cash['max']))
                    $query = $query->having('CASH', '<', $cash['max']);

                if($recentOrder)
                    $query = $query->orderBy('ID', 'desc');
            }
        }

        $query = $query->take(30)->get();

     	return \Response::make( 
     		\View::make('admin.results')
            	->with('currentUser',		$currentUser)
     			->with('users', 			$query)
     			->with('table', 			$table)
                ->with('breadCrumb',        ['Dashboard', 'Administration', '<a href="' . \URL::to('/admin/search') . '">Search User</a>', 'Results'])
                ->with('pageheadTitle',     'Search User')
     	, 200 );
    }

    /*
     *  Cash Log
    */
    public function transaction()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        if($currentUser->ADMINLEVEL < \Config::get('irresistible.search')) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        return \Response::make(
            \View::make('admin.transactions')
                ->with('currentUser',       $currentUser)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Transaction Log'])
                ->with('pageheadTitle',     'Search Transaction Log')
        , 200 );
    }


    public function transactionSearch()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        if($currentUser->ADMINLEVEL < \Config::get('irresistible.search')) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        $validation = \Validator::make(\Input::all(), static::$searchTransactionRules);

        if($validation->fails()) {
            return \Redirect::to('/admin/transactions')->withInput(\Input::all())->withErrors($validation);
        }

        if(\Input::has('toName') == false && \Input::has('fromName') == false) {
            return \Redirect::to('/admin/transactions')->withInput(\Input::all())->withErrors(['There must be either to or from username specified.']);
        }

        // Get fields
        $toData = null;
        $fromData = null;

        if(\Input::has('toName') == true) {
            $toData = \User::where('NAME', '=', \Input::get('toName'))->first();
        }

        if(\Input::has('fromName') == true) {
            $fromData = \User::where('NAME', '=', \Input::get('fromName'))->first();
        }

        // Search type
        if(\Input::get('searchType') == 0) {
            $transactionsLog = \Cash::orderBy('DATE', 'desc');
        } else {
            $transactionsLog = \Coins::orderBy('DATE', 'desc');
        }

        if(is_null($toData) == false)
            $transactionsLog = $transactionsLog->where('TO_ID', '=', $toData->ID);

        if(is_null($fromData) == false)
            $transactionsLog = $transactionsLog->where('FROM_ID', '=', $fromData->ID);

        $transactionsLog = $transactionsLog->paginate(20);

        return \Response::make(
            \View::make('admin.transactions_show')
                ->with('currentUser',       $currentUser)
                ->with('transactionsLog',   $transactionsLog)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Transaction Log'])
                ->with('pageheadTitle',     'Search Transaction Log')
        , 200 );
    }
}
