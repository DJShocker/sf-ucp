<?php

class CrowdfundController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $currentUser = User::find(Session::get('UUID'));

        if ( ! $currentUser) {
            return App::abort('404');
        }

       	$crowdfundData = Crowdfund::with('patreons')->get();

        return Response::make(
            View::make('crowdfund.index')
            	->with('currentUser', $currentUser)
                ->with('breadCrumb',        ['Crowdfunding'])
                ->with('pageheadTitle',     'Feature Crowdfunding')
                ->with('crowdfundData',		$crowdfundData)
            , 200
        );
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $currentUser = User::find(Session::get('UUID'));

        if ( ! $currentUser) {
            return App::abort('404');
        }

       	$crowdfund = Crowdfund::findOrFail($id);

       	$crowdfundData = Crowdfund::orderBy('RELEASE_DATE', 'asc')->get();

       	$userPledge = CrowdfundPatreon::where('CROWDFUND_ID', $crowdfund->ID)->where('USER_ID', $currentUser->ID)->sum('AMOUNT');

       	$patreons = CrowdfundPatreon::where('CROWDFUND_ID', $crowdfund->ID)->select('*', DB::raw('SUM(AMOUNT) as TOTAL'))->groupBy('USER_ID')->orderBy('TOTAL', 'desc')->with('user')->get();

        return Response::make(
            View::make('crowdfund.show')
            	->with('currentUser', $currentUser)
                ->with('breadCrumb',        ['Crowdfunding', $crowdfund->FEATURE])
                ->with('pageheadTitle',     $crowdfund->FEATURE)
                ->with('crowdfund',			$crowdfund)
                ->with('patreons',			$patreons)
                ->with('crowdfundData',		$crowdfundData)
                ->with('userPledge',		$userPledge)
            , 200
        );
	}


    /**
     * Refund players
     *
     * @param  int  $id
     * @return Response
     */
    public function refund($id)
    {
        $currentUser = User::find(Session::get('UUID'));

        if ( ! $currentUser) {
            return App::abort('404');
        }

        $crowdfund = Crowdfund::findOrFail($id);

        if ($currentUser->ID != Config::get('irresistible.owner')) {
            return Redirect::route('crowdfund.show', $id)->withErrors(["Insufficient permissions."]);
        }

        // dont refund shit with a release date
        if ($crowdfund->RELEASE_DATE) {
            return Redirect::route('crowdfund.show', $id)->withErrors(["You cannot refund a crowdfund that is assigned a release date."]);
        }

        // search patreons
        $patreons = CrowdfundPatreon::where('CROWDFUND_ID', $crowdfund->ID)->select('*', DB::raw('SUM(AMOUNT) as TOTAL'))->groupBy('USER_ID')->orderBy('TOTAL', 'desc')->with('user')->get();

        // update the users
        foreach ($patreons as $key) {
            $userUpdated = \User::where('ID', '=', $key->user->ID)->update(['COINS' => $key->user->COINS + $key->TOTAL]);
        }

        // delete all patreons
        $patreons = CrowdfundPatreon::where('CROWDFUND_ID', $crowdfund->ID)->delete();

        // redirect
        return Redirect::route('crowdfund.show', $id)->with('success', "All contributions have been refunded.");
    }

	/**
	 * Pledge a donation
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function pledge($id)
	{
        $currentUser = User::find(Session::get('UUID'));

        if ( ! $currentUser) {
            return App::abort('404');
        }

        $crowdfund = Crowdfund::findOrFail($id);

        if ($crowdfund->isEnded()) {
            return Redirect::route('crowdfund.show', $id)->withErrors(["This crowdfund has ended and contributions will not work."]);
        }

        if ($currentUser->ONLINE) {
            return Redirect::route('crowdfund.show', $id)->withErrors(["Disconnect from in-game to use this feature."]);
        }

        $validation = Validator::make(Input::all(), ['contribution' => 'required|numeric|min:10']);

        if($validation->fails()) {
            return Redirect::route('crowdfund.show', $id)->withErrors($validation);
        }

        $contribution = Input::get('contribution');

        if ($currentUser->COINS < $contribution) {
            return Redirect::route('crowdfund.show', $id)->withInput(Input::all())->withErrors(["You don't have enough irresistible coins to make this contribution."]);
        }

        try
        {
			// update contribution info
			$userUpdated = \User::where('ID', '=', $currentUser->ID)->update(['COINS' => $currentUser->COINS - $contribution]);

			// insert into database
			$userPledge = new CrowdfundPatreon;
			$userPledge->USER_ID = $currentUser->ID;
			$userPledge->CROWDFUND_ID = $crowdfund->ID;
			$userPledge->AMOUNT = $contribution;
			$userPledge->save();

			// redirect
			$formatAmount = number_format($contribution, 2);
			return Redirect::route('crowdfund.show', $id)->with('success', "Thanks for contributing {$formatAmount} IC to the {$crowdfund->FEATURE}.");
		}
		catch (Exception $e)
		{
            return Redirect::route('crowdfund.show', $id)->withErrors(['There was an error creating your contribution to this feature.']);
		}

	}

}
