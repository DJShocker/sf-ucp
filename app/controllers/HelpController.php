<?php

class HelpController extends BaseController {

    static $submitRules = [
        "subject"   =>  "required|max:64",
        "category"  =>  "required|integer|min:0|max:4",
        "content"   =>  "required"
    ];

    static $deleteRules = [
        "id"        => "required|exists:HELP,ID"
    ];

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

        $help = Help::orderBy('CATEGORY', 'asc')->with('author')->get();

        if(!$help) {
            return App::abort('404');
        }

        return Response::make(
            View::make('help.index')
       			->with('currentUser', 		$currentUser)
                ->with('helpTopics',        $help)
                ->with('breadCrumb',        ['Dashboard', 'Help Centre'])
                ->with('pageheadTitle',     'Help Centre')
            , 200
        );
    }

    public function write()
    {
        $currentUser = User::find(Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        return Response::make(
            View::make('help.write')
                ->with('currentUser',       $currentUser)
                ->with('breadCrumb',        ['Dashboard', '<a href="/help">Help Centre</a>', 'Write Thread'])
                ->with('pageheadTitle',     'Help Centre')
            , 200
        );
    }

    public function edit($id)
    {
        $currentUser = User::find(Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        $topic = Help::where('ID', '=', $id)->first();

        if (!$topic) {
            return App::abort('404');
        }

        return Response::make(
            View::make('help.edit')
                ->with('topic',             $topic)
                ->with('currentUser',       $currentUser)
                ->with('breadCrumb',        ['Dashboard', '<a href="/help">Help Centre</a>', 'Edit Thread'])
                ->with('pageheadTitle',     'Help Centre')
            , 200
        );
    }

    public function save($id)
    {
        $user = User::find(Session::get('UUID'));

        if(!$user) {
            return App::abort('404');
        }

        $topic = Help::where('ID', '=', $id)->first();

        if (!$topic) {
            return App::abort('404');
        }

        $validation = Validator::make( Input::all( ), static::$submitRules );

        if($validation->fails()) {
            return Redirect::route('help.edit', $topic->ID)->withErrors($validation)->withInput();
        }

        try
        {
            $content = trim(Input::get('content'));

            if (strlen(strip_tags(html_entity_decode($content))) > 2048)
                return Redirect::route('help.edit', $topic->ID)->withErrors(["Please ensure that the character limit is less than 2048."])
                                                    ->withInput();

            if ($user->ID != $getHelp->USER_ID && $user->ADMINLEVEL < 5)
                return Redirect::to( "/dashboard" )->withErrors(["You do not have permission to use this feature."]);

            $category  = trim(strip_tags(Input::get('category')));
            $subject   = trim(strip_tags(Input::get('subject')));
            Help::where('ID', '=', $id)->update(['CATEGORY' => $category, 'SUBJECT' => $subject, 'CONTENT' => $content]);

            Session::flash('success', "You've edited a thread.");
            return Redirect::to( "/help" );

        }
        catch(\Exception $e)
        {
            return Redirect::to('/help')->withErrors(["Unable to remove help thread due to an internal error."]);
        }
    }

    public function destroy()
    {
        $user = User::find(Session::get('UUID'));

        if(!$user) {
            return App::abort('404');
        }

        $validation = Validator::make( Input::all(), static::$deleteRules );

        if($validation->fails())
            return Redirect::to('/help')->withErrors($validation);

        try {
            $getHelp = Help::where('ID', '=', trim(Input::get('id')))->first();

            if($getHelp == NULL)
                return Redirect::to('/help')->withErrors(["You are unable to remove this thread as it does not exist."]);

            if($user->ID != $getHelp->USER_ID && $user->ADMINLEVEL < 5)
                return Redirect::to('/dashboard')->withErrors(["Insufficient permissions to remove this thread."]);

            $deletion = DB::table('HELP')->where('ID', '=', trim(Input::get('id')))->delete();
            Session::flash('success', "You've successfully removed a thread.");
            return Redirect::to('/help');

        }
        catch(\Exception $e)
        {
            return Redirect::to('/help')->withErrors(["Unable to remove help thread due to an internal error."]);
        }
    }

    public function create()
    {
        $user = User::find(Session::get('UUID'));

        if(!$user) {
            return App::abort('404');
        }

        $validation = Validator::make( Input::all( ), static::$submitRules );

        if($validation->fails())
            return Redirect::to('/help/write')->withErrors($validation)
                                              ->withInput();

        try
        {
            $content = trim(Input::get('content'));

            if( strlen(strip_tags(html_entity_decode($content))) > 2048 )
                return Redirect::to( "/help/write" )->withErrors(["Please ensure that the character limit is less than 2048."])
                                                    ->withInput();

            if( $user->ADMINLEVEL < 3 )
                return Redirect::to( "/dashboard" )->withErrors(["You do not have permission to use this feature."]);

            $subject = trim( strip_tags( Input::get( 'subject' ) ) ); // Because we're exploding with |

            $newHelp = new Help;
            $newHelp->USER_ID   = $user->ID;
            $newHelp->CATEGORY  = trim(strip_tags(Input::get('category')));
            $newHelp->SUBJECT   = $subject;
            $newHelp->CONTENT   = $content;
            $newHelp->save();

            Session::flash('success', "You've added a new thread!");
            return Redirect::to( "/help" );
        }
        catch(\Exception $e)
        {
            return Redirect::to('/help')->withErrors(["Unable to create help thread due to an internal error."]);
        }
    }
}
