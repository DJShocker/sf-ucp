<?php namespace Admin;

use BaseController;

class PlayerController extends BaseController{

    static $searchRules = array(
        "table" =>  "required",
        "name"  =>  "min:2|max:24"
    );

    static $banRules = array(
        "name"  =>  "required|unique:BANS,NAME|exists:USERS",
        "reason" => "required|min:3|max:32"
    );

    static $chngpwRules = array(
        "name"      =>  "required|exists:USERS,NAME",
        "password"  =>  "required|min:3|max:24"
    );

    static $unbanRules = array(
        "name"  =>  "exists:BANS,NAME",
        "ip"    =>  "ip|exists:BANS,IP"
    );

    static $classbanRules = array(
        "name"  =>  "required|exists:USERS"
    );

    static $jailRules = array(
        "name"      =>  "required|exists:USERS",
        "seconds"   =>  "required|numeric|min:0|max:20000"
    );

    static $muteRules = array(
        "name"      =>  "required|exists:USERS",
        "seconds"   =>  "required|numeric|min:0"
    );

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
        return \Response::make(
            \View::make('admin.player')
                ->with('currentUser',       $currentUser)
                ->with('breadCrumb',        ['Dashboard', 'Administration', 'Player Management'])
                ->with('pageheadTitle',     'Player Management')
        , 200 );
    }

    public function armyban()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 3)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make( \Input::all(), static::$classbanRules );

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        $name = trim(strip_tags(\Input::get('name')));
        $user = \User::where('NAME', '=', $name)->first();

        if(is_null($user))
            return \Redirect::to("/admin/manage")->withErrors(["This user does not exist."]);

        if($user->ADMINLEVEL >= $issuer->ADMINLEVEL && $issuer->ID != \Config::get('irresistible.owner'))
            return \Redirect::to('/admin/manage')->withErrors(["This user has an administrative level equal or less than yours."]);

        if($user->ARMY_BAN >= 3)
            return \Redirect::to( "/admin/manage" )->withErrors(["This user is already army-banned."]);

        $user->ARMY_BAN += 1;

        if ($user->save())
        {
            \Log::info($issuer->NAME . " has army-warned " . $name);
            \Session::flash('success', "{$user->NAME} has been army-warned [{$user->ARMY_BAN}/3].");
            return \Redirect::to( "/admin/manage" );
        }
    }

    public function unarmyban()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 4)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make( \Input::all(), static::$classbanRules );

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        $name = trim(strip_tags(\Input::get('name')));
        $user = \User::where('NAME', '=', $name)->first();

        if (!$user->ARMY_BAN)
            return \Redirect::to( "/admin/manage" )->withErrors(["This user is not army-banned."]);

        $user->ARMY_BAN -= 1;

        if ($user->save()) {
            \Log::info($issuer->NAME . " has removed a army-warn for " . $name);
            \Session::flash('success', "Removed 1 army warn from {$user->NAME} [{$user->ARMY_BAN}/3].");
            return \Redirect::to( "/admin/manage" );
        }
    }

    public function copban()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 3)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make( \Input::all(), static::$classbanRules );

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        $name = trim(strip_tags(\Input::get('name')));
        $user = \User::where('NAME', '=', $name)->first();

        if($user->ADMINLEVEL >= $issuer->ADMINLEVEL && $issuer->ID != \Config::get('irresistible.owner'))
            return \Redirect::to('/admin/manage')->withErrors(["This user has an administrative level equal or less than yours."]);

        if($user->COP_BAN >= 3)
            return \Redirect::to( "/admin/manage" )->withErrors(["This user is already cop-banned."]);

        $user->COP_BAN += 1;

        if ($user->save()) {
            \Log::info($issuer->NAME . " has cop-banned " . $name);
            \Session::flash('success', "{$user->NAME} has been cop-warned [{$user->COP_BAN}/3].");
            return \Redirect::to( "/admin/manage" );
        }
    }

    public function uncopban()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 4)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make( \Input::all(), static::$classbanRules );

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        $name    = trim(strip_tags(\Input::get('name')));
        $user = \User::where('NAME', '=', $name)->first();

        if( !$user->COP_BAN )
            return \Redirect::to( "/admin/manage" )->withErrors(["This user is not cop-banned."]);

        $user->COP_BAN -= 1;

        if ($user->save()) {
            \Log::info($issuer->NAME . " has removed a cop-warn for " . $name);
            \Session::flash('success', "Removed 1 cop warn from {$user->NAME} [{$user->COP_BAN}/3].");
            return \Redirect::to( "/admin/manage" );
        }
    }

    public function ban()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 3)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make( \Input::all(), static::$banRules );

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        try
        {
            $name = trim(strip_tags(\Input::get('name')));
            $reason = strip_tags( \Input::get( 'reason' ) );
            $user = \User::where( 'NAME', '=', $name )->first();
            $date = time();

            if($user->ADMINLEVEL >= $issuer->ADMINLEVEL && $issuer->ID != \Config::get('irresistible.owner'))
                return \Redirect::to('/admin/manage')->withErrors(["This user has an administrative level equal or less than yours."]);

            $inserBan = \DB::table( 'BANS' )->insert(
                array(
                    'NAME' => $user->NAME,
                    'IP' => $user->LAST_IP,
                    'REASON' => $reason,
                    'BANBY' => $issuer->NAME,
                    'DATE' => $date,
                    'EXPIRE' => 0,
                )
            );

            \Log::info($issuer->NAME . " has banned NAME: " . $name . " | IP: " . $user->LAST_IP . " | DATE: " . date('Y-m-d h:i:s A', $date));
            \Session::flash('success', ucfirst($user->NAME) . ' has been banned for "' . $reason . '".' );
            return \Redirect::to( '/admin/manage' );
        }
        catch(\Exception $e)
        {
            return \Redirect::to('/admin/manage')->withErrors(["Failed to ban player due to an internal error."]);
        }
    }

    public function unban()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 5)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make( \Input::all(), static::$unbanRules );

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        try
        {
            $name = trim(htmlentities(\Input::get('name')));
            $ip = trim(htmlentities(\Input::get('ip')));

            if(\Input::has('ip'))
            {
                $deleteBan = \DB::table( 'BANS' )->where( 'IP' , '=' , $ip )->delete( );
            }
            else 
            {
                $deleteBan = \DB::table( 'BANS' )->where( 'NAME' , '=' , $name )->delete( );                
            }

            if( $deleteBan == NULL )
            {
                return \Redirect::to( "/admin/manage" )->withErrors(["This user does not exist."]);
            }

            \Log::info($issuer->NAME . " has unbanned " . (\Input::has('ip') ? $ip : $name));
            \Session::flash('success', (\Input::has('ip') ? $ip : $name) . ' has been unbanned.' );
            return \Redirect::to( '/admin/manage' );
        }
        catch(\Exception $e)
        {
            return \Redirect::to('/admin/manage')->withErrors(["Failed to unban player due to an internal error."]);
        }
    }

    public function mute()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 2)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make(\Input::all(), static::$muteRules);

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        try
        {
            $name = trim(strip_tags(\Input::get('name')));
            $seconds = \Input::get('seconds');
            $user = \User::where('NAME', '=', $name)->first();

            if($user->ADMINLEVEL >= $issuer->ADMINLEVEL && $issuer->ID != \Config::get('irresistible.owner'))
                return \Redirect::to('/admin/manage')->withErrors(["This user has an administrative level equal or less than yours."]);
           
            $user = \User::where('NAME', '=', $name)->update(['MUTE_TIME' => time() + $seconds]);
            \Log::info($issuer->NAME . " has muted ".$name." for " . $seconds . " seconds.");

            \Session::flash('success', 'Muted ' . $name . ' for ' . $seconds . ' seconds successfully!');
            return \Redirect::to('/admin/manage');
        }
        catch(\Exception $e)
        {
            return \Redirect::to('/admin/manage')->withErrors(["Failed to mute player due to an internal error."]);
        }
    }

    public function jail()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 1)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make(\Input::all(), static::$jailRules);

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        try
        {
            $name = trim(strip_tags(\Input::get('name')));
            $seconds = \Input::get('seconds');
            $user = \User::where('NAME', '=', $name)->first();

            if( is_null($user) )
                return \Redirect::to("/admin/manage")->withErrors(["This user does not exist."]);

            if($user->ADMINLEVEL >= $issuer->ADMINLEVEL && $issuer->ID != \Config::get('irresistible.owner'))
                return \Redirect::to('/admin/manage')->withErrors(["This user has an administrative level equal or less than yours."]);
           
            $user = \User::where('NAME', '=', $name)->update(['JAIL_TIME' => $seconds, 'JAIL_ADMIN' => 1]);
            \Log::info($issuer->NAME . " has jailed ".$name." for " . $seconds . " seconds.");

            \Session::flash('success', 'Jailed ' . $name . ' for ' . $seconds . ' seconds successfully!');
            return \Redirect::to('/admin/manage');
        }
        catch(\Exception $e)
        {
            return \Redirect::to('/admin/manage')->withErrors(["Failed to jail player due to an internal error."]);
        }
    }

    public function password()
    {
        $issuer = \User::find(\Session::get('UUID'));

        if(!$issuer)
            return \App::abort('404');

        if($issuer->ADMINLEVEL < 5)
            return \Redirect::to('/dashboard')->withErrors(["Insufficient administrative permissions."]);

        $validation = \Validator::make(\Input::all(), static::$chngpwRules);

        if($validation->fails())
            return \Redirect::to("/admin/manage")->withErrors($validation);

        try
        {
            $name = trim(strip_tags(\Input::get('name')));
            $salt = \Str::random(24);
            $new_password = strtoupper(\Hash::make(\Input::get('password'), $salt)); // It's going to be hashed anyway... So #YOLO
            $user = \User::where('NAME', '=', $name)->first();

            if( is_null($user) )
                return \Redirect::to("/admin/manage")->withErrors(["This user does not exist."]);

            if($user->ADMINLEVEL >= $issuer->ADMINLEVEL && $issuer->ID != \Config::get('irresistible.owner'))
                return \Redirect::to('/admin/manage')->withErrors(["This user has an administrative level equal or less than yours."]);
           
            $user = \User::where('NAME', '=', $name)->update(['PASSWORD' => $new_password, 'SALT' => $salt]);
            \Log::info($issuer->NAME . " has changed ".$name."'s password.");

            \Session::flash('success', 'Changed user password successfully!');
            return \Redirect::to('/admin/manage');
        }
        catch(\Exception $e)
        {
            return \Redirect::to('/admin/manage')->withErrors(["Failed to change password due to an internal error."]);
        }
    }
}
