<?php

class AuthController extends BaseController {

    /**
     * Default view handeling for /auth/login & / request
     */
    public function index()
    {
        if (Session::has('authenticated') && Session::get('authenticated')) {
            return Redirect::to('/dashboard');
        }

        return Response::make(View::make('frontend.login.cnr'), 200);
    }

    /**
     * Create new session
     */
    public function create()
    {
        if (Session::has('authenticated') && Session::get('authenticated') == true) {
            return Redirect::to('/dashboard')->withErrors(["You're already authenticated!"]);
        }

        $time = time();

        if(Cookie::has('attempts') && Cookie::get('attempts') >= 3) {
            return Redirect::to('/')->withErrors(['Too many attempts. Try again later.']);            
        }

        $attemptAuthentication = User::username(Input::get('username'))->first();

        if(!$attemptAuthentication) {
            return Redirect::to('/')->withErrors(['Invalid username or password.'])->withCookie(Cookie::make('attempts', Cookie::get('attempts') + 1, 5));
        }

        $credentials = [
            'NAME'     => trim(strip_tags(Input::get('username'))),
            'PASSWORD' => Hash::make(trim(Input::get('password')), $attemptAuthentication->SALT),
        ];

        $isBanned = DB::table('BANS')->where('NAME', '=', $credentials['NAME'])->first();

        if($isBanned) {
            return Redirect::to('/')->withErrors(['This account is banned.']);
        }

        $finalAttempt = User::where('NAME', '=', $credentials['NAME'])
                        ->where('PASSWORD', '=', $credentials['PASSWORD'])
                        ->first();

        if($finalAttempt)
        {
            if($finalAttempt->ADMINLEVEL)
                Session::put('admin_role', $finalAttempt->ADMINLEVEL);
            
            Session::put('authenticated', true);
            Session::put('UUID', $finalAttempt->ID);
            Session::flash('success', 'You have successfully logged in, ' . ucfirst($finalAttempt->NAME) . '.');
            return Redirect::to('/dashboard');
        }
        else
        {
            return Redirect::to('/')
                    ->withErrors(["Invalid username or password."]);
        }
    }

    /**
     * Destroy if session exists.
     */
    public function destroy()
    {
        if(Session::has('authenticated')) 
        {
            Session::remove('authenticated');
            Session::remove('UUID');
            Session::flush();            
        }
        return Redirect::to('/');
    }
}
