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

        $isClanLeader = $gang->is_leader($currentUser);

        $leaders = User::where('ID', $gang->LEADER)->get();
        $coleaders = User::whereIn('ID', [$gang->COLEADER])->get();
        $leaders = $leaders->merge($coleaders);

        $members = User::where('GANG_ID', '=', $gang->ID)->whereNotIn('ID', [$gang->LEADER, $gang->COLEADER])->get();

        // merge leaders and members
       	$members = $leaders->merge($members);

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
            return Response::json(array('error' => "You cannot kick leaders of this gang"));
        }

        // check if co-leader
        if ($gang->COLEADER == $user->ID) {
            $gang->COLEADER = 0;
            $gang->save();
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
