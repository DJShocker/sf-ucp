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

    static $playerSearchTransactionRules = [
        "searchType" =>  "required|integer|between:0,1",
        "toName"     =>  "string|min:2|max:24|exists:USERS,NAME",
        "fromName"   =>  "string|min:2|max:24|exists:USERS,NAME"
    ];

    static $gangSearchTransactionRules = [
        "username"   =>  "string|min:2|max:24|exists:USERS,NAME",
        "gangname"   =>  "string|min:2|max:32|exists:GANGS,NAME"
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

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ADMINLEVEL < \Config::get('irresistible.search'))
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
            case "bankmoney":
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

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ADMINLEVEL < \Config::get('irresistible.search'))
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);

      	$validation = \Validator::make(\Input::all(), static::$searchRules);

        if ($validation->fails())
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

        if (\Input::has('name') && \Input::has('ip'))
        {
          	return \Redirect::to('/admin/search')->withErrors(['One name or IP is required only for a query. Not both.']);
        }


      	$query = \DB::table($tableSelection);

        if ( \Input::has("ip") ) $query = $query->where( "IP", "LIKE", trim( strip_tags( $ipAddress ) )."%" );
        else
        {
    	   //if (!empty($userName))
           	$query->where( "NAME", "LIKE", "%".trim( strip_tags( $userName ) )."%" );

            // Only for USERS
            if (!$table)
            {
                if (!empty($score['min']))
                    $query = $query->having('SCORE', '>', $score['min']);

                if (!empty($score['max']))
                    $query = $query->having('SCORE', '<', $score['max']);

                if (!empty($cash['min']))
                    $query = $query->having('CASH', '>', $cash['min']);

                if (!empty($cash['max']))
                    $query = $query->having('CASH', '<', $cash['max']);

                if ($recentOrder)
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

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ADMINLEVEL < \Config::get('irresistible.search')) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        return \Response::make(
            \View::make('admin.transactions.index')
                ->with('currentUser',       $currentUser)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Transaction Log'])
                ->with('pageheadTitle',     'Search Transaction Log')
        , 200 );
    }

    public function playerTransactionSearch()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ADMINLEVEL < \Config::get('irresistible.search')) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        $validation = \Validator::make(\Input::all(), static::$playerSearchTransactionRules);

        if ($validation->fails()) {
            return \Redirect::to('/admin/transactions')->withInput(\Input::all())->withErrors($validation);
        }

        if (\Input::has('toName') == false && \Input::has('fromName') == false) {
            return \Redirect::to('/admin/transactions')->withInput(\Input::all())->withErrors(['There must be either to or from username specified.']);
        }

        // Get fields
        $toData = null;
        $fromData = null;

        if (\Input::has('toName') == true) {
            $toData = \User::where('NAME', '=', \Input::get('toName'))->first();
        }

        if (\Input::has('fromName') == true) {
            $fromData = \User::where('NAME', '=', \Input::get('fromName'))->first();
        }

        // Search type
        if (\Input::get('searchType') == 0) {
            $transactionsLog = \Cash::whereNotIn('NATURE', ['gang withdraw', 'gang deposit'])->orderBy('DATE', 'desc');
        } else {
            $transactionsLog = \Coins::orderBy('DATE', 'desc');
        }

        if (is_null($toData) == false)
            $transactionsLog = $transactionsLog->where('TO_ID', '=', $toData->ID);

        if (is_null($fromData) == false)
            $transactionsLog = $transactionsLog->where('FROM_ID', '=', $fromData->ID);

        $transactionsLog = $transactionsLog->paginate(20);

        return \Response::make(
            \View::make('admin.transactions.player')
                ->with('currentUser',       $currentUser)
                ->with('cashNature',        \Input::get('searchType') == 0)
                ->with('transactionsLog',   $transactionsLog)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Player Transaction Log'])
                ->with('pageheadTitle',     'Search Player Transaction Log')
        , 200 );
    }

    public function gangTransactionSearch()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ADMINLEVEL < \Config::get('irresistible.search')) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        $validation = \Validator::make(\Input::all(), static::$gangSearchTransactionRules);

        if ($validation->fails()) {
            return \Redirect::to('/admin/transactions')->withInput(\Input::all())->withErrors($validation);
        }

        if (\Input::has('gangname') == false && \Input::has('username') == false) {
            return \Redirect::to('/admin/transactions')->withInput(\Input::all())->withErrors(['There must be either to or from username specified.']);
        }

        $userData = null;
        $gangData = null;

        // Get fields
        if (\Input::has('username') == true) {
            $userData = \User::where('NAME', '=', \Input::get('username'))->first();
        }

        // Get fields
        if (\Input::has('gangname') == true) {
            $gangData = \Gang::where('NAME', '=', \Input::get('gangname'))->first();
        }

        $transactionsLog = \Cash::with('fromGang', 'toUser')->whereIn('NATURE', ['gang withdraw', 'gang deposit'])->orderBy('DATE', 'desc');

        if (is_null($userData) == false)
            $transactionsLog = $transactionsLog->where('TO_ID', '=', $userData->ID);

        if (is_null($gangData) == false)
            $transactionsLog = $transactionsLog->where('FROM_ID', '=', $gangData->ID);

        $transactionsLog = $transactionsLog->paginate(20);

        return \Response::make(
            \View::make('admin.transactions.gang')
                ->with('currentUser',       $currentUser)
                ->with('transactionsLog',   $transactionsLog)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Gang Transaction Log'])
                ->with('pageheadTitle',     'Search Gang Transaction Log')
        , 200 );
    }

    public function feedback()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ADMINLEVEL < 6) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        $feedback = \Feedback::with(['user'])->orderBy('DATE', 'desc')->get();

        return \Response::make(
            \View::make('admin.feedback')
                ->with('currentUser', $currentUser)
                ->with('feedback', $feedback)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Feedback'])
                ->with('pageheadTitle',     'Feedback')
        , 200 );
    }

    public function adminLogs()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ADMINLEVEL < 6) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        $adminLogs = \AdminActionLog::with(['user'])->orderBy('DATE', 'desc')->paginate(20);

        return \Response::make(
            \View::make('admin.logs')
                ->with('currentUser', $currentUser)
                ->with('adminLogs', $adminLogs)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Admin Logs'])
                ->with('pageheadTitle',     'Admin Logs')
        , 200 );
    }

    public function searchAdminLogs()
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if (!$currentUser) {
            return App::abort('404');
        }

        if ($currentUser->ADMINLEVEL < 6) {
            return \Redirect::to('/dashboard')->withErrors(["You don't have permission to access this page."]);
        }

        $adminLogs = \AdminActionLog::with(['user']);

        // search username
        if (\Input::has('username') == true) {
            $user = \User::where('NAME', '=', \Input::get('username'))->select('ID')->first();

            if (is_null($user) == false)
                $adminLogs = $adminLogs->where('USER_ID', '=', $user->ID);
        }

        // search action
        if (\Input::has('action') == true) {
            $adminLogs = $adminLogs->where('ACTION', 'LIKE', '%' . \Input::get('action') . '%');
        }

        // before date
        if (\Input::has('beforeDate') == true) {
            $adminLogs = $adminLogs->where('DATE', '<=', \Input::get('beforeDate'));
        }

        // after date
        if (\Input::has('fromDate') == true) {
            $adminLogs = $adminLogs->where('DATE', '>=', \Input::get('fromDate'));
        }

        $adminLogs = $adminLogs->orderBy('DATE', 'desc')->paginate(20);

        return \Response::make(
            \View::make('admin.logs_show')
                ->with('currentUser', $currentUser)
                ->with('adminLogs', $adminLogs)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Admin Logs'])
                ->with('pageheadTitle',     'Admin Logs')
        , 200 );
    }
}
