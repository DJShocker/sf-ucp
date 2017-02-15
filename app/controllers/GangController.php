<?php

class GangController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth');
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
            case "tag":
                $field .= "CLAN_TAG";
                break;
            case "name":
                $field .= "NAME";
                break;
            case "score":
                $field .= "SCORE";
                break;
            case "bank":
                $field .= "BANK";
                break;
            case "kills":
                $field .= "KILLS";
                break;
            case "deaths":
                $field .= "DEATHS";
                break;
            case "private":
                $field .= "INVITE_ONLY";
                break;
            case "member":
            	$field .= "MEMBERS";
            	break;
            default:
                $inputField = "tag";
                $field .= "CLAN_TAG";
                break;
        }

        // sort
        $currentSort = ($sort == "desc") ? "asc" : "desc";

        // select relevant gangs
       	$gangs = Gang::leftJoin('USERS', 'USERS.GANG_ID', '=', 'GANGS.id')
       				 ->selectRaw('GANGS.*, count(USERS.id) as MEMBERS')
       				 ->groupBy('GANGS.ID')
       				 ->orderBy( $field, $sort )
       				 ->paginate(15);

        return Response::make(
            View::make('gangs.highscores')
            	->with('gangs',				$gangs)
                ->with( "sort",             $currentSort )
                ->with( "field",            $inputField )
                ->with('currentUser',       $currentUser)
                ->with('pageheadTitle',     'Gang Highscores')
                ->with('breadCrumb',        ['Gangs', 'Highscores'])
            , 200
        );
    }

    public function show($id, $name)
    {
        $currentUser = User::find(Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        $gang = Gang::find($id);

        if (is_null($gang)) {
            return \Redirect::to('/dashboard')->withErrors(["Gang could not be found."]);
        }

        // check if current user is a leader
        $isClanLeader = $gang->is_leader($currentUser);

        // get the gang leader
        $leader = User::where('ID', $gang->LEADER)->first();

        // get the coleaders
        $coleaderUserIds = GangColeader::where('GANG_ID', '=', $gang->ID)->lists('USER_ID');
        $coleaders = User::whereIn('ID', $coleaderUserIds)->get();

        // merge leaders and coleaders into an collection
        $coleaders = $coleaders->add($leader);

        // reverse the coleaders collection otherwise it will show all coleaders first
        $coleaders = $coleaders->reverse();

        // including leader in the coleaders user id array just for the purpose of filtering them out of the member list
        $coleaderUserIds[] = $leader->ID;

        // get all members except the coleaders
        $members = User::where('GANG_ID', '=', $gang->ID)->whereNotIn('ID', $coleaderUserIds)->limit(20)->get();

        // merge leaders and members
       	$members = $coleaders->merge($members);

        // average activity
        $averageActivity = ceil(User::where('GANG_ID', '=', $gang->ID)->avg(DB::raw('UPTIME - WEEKEND_UPTIME')));

        return Response::make(
            View::make('gangs.show')
            	->with('gang',				$gang)
            	->with('members',			$members)
            	->with('averageActivity',	$averageActivity)
            	->with('isClanLeader',		$isClanLeader)
                ->with('currentUser',       $currentUser)
                ->with('pageheadTitle',     e($gang->NAME))
                ->with('breadCrumb',        ['Gang', e($gang->NAME)])
            , 200
        );
    }

    public function kick($id, $userId)
    {
    	// LEADER CHECK
        $currentUser = User::find(Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        // gang check
        $gang = Gang::find($id);

        if (is_null($gang)) {
            return Response::json(array('error' => 'Gang does not exist'));
        }

        // user check
        $user = User::find($userId);

        if (is_null($user)) {
            return Response::json(array('error' => "User does not exist"));
        }

        // check if user is a leader
        if (! $gang->is_leader($currentUser)) {
            return Response::json(array('error' => "You are not a leader of this gang"));
        }

        // check if user is online
        if ($user->ONLINE) {
            return Response::json(array('error' => "You cannot kick players that are online here"));
        }

        // check if user is in gang
        if ($user->GANG_ID != $gang->ID) {
            return Response::json(array('error' => "You cannot kick players that aren't in your gang"));
        }

        // check if kicking user is a leader
        if ($gang->LEADER == $user->ID) {
            return Response::json(array('error' => "You cannot kick the leader of the gang"));
        }

        // check if co-leader
        $coleader = GangColeader::where('GANG_ID', '=', $gang->ID)->where('USER_ID', '=', $user->ID)->first();

        // destroy coleader record if valid
        if ( ! is_null($coleader)) {
            GangColeader::where('GANG_ID', '=', $gang->ID)->where('USER_ID', '=', $user->ID)->delete();
        }

        // reset his gang
   		$user->GANG_ID = -1;

        // respond
        if ($user->save()) {
       		return Response::json(array('message' => "Successfully removed member"));
        } else {
            return Response::json(array('error' => "Couldn't kick player due to an internal error"));
        }
    }

}
