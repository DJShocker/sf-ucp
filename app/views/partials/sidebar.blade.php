<nav id="page-leftbar" role="navigation">
	<ul style="" class="acc-menu" id="sidebar">
		<li @if(Request::is('dashboard')) class="active" @endif><a href="{{URL::route('dashboard')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
		<li @if(Request::is('crowdfund/*')) class="active" @endif><a href="{{URL::route('crowdfund.index')}}"><i class="fa fa-heart"></i> <span>Feature Crowdfunding <span class="label label-info" style="margin-left: 1em">BETA</span></span></a></li>
        <li @if(Request::is('economics')) class="active" @endif><a href="{{URL::route('economics')}}"><i class="fa fa-money"></i> <span>Economics</span></a></li>
		<li @if(Request::is('help')) class="active" @endif><a href="{{URL::route('help')}}"><i class="fa fa-info-circle"></i> <span>Help Centre</span></a></li>
		<li @if(Request::is('highscores')) class="active" @endif><a href="{{URL::route('highscores')}}"><i class="fa fa-trophy"></i> <span>Highscores</span></a></li>
		<li @if(Request::is('seasonal')) class="active" @endif><a href="{{URL::route('seasonal')}}"><i class="fa fa-leaf"></i> <span>Seasonal</span></a></li>

		<li class="closed hasChild {{Request::is('gangs/*') ? 'open active' : ''}} "><a href="javascript:;"><i class="fa fa-group"></i> <span>Gangs</a>
            <ul class="acc-menu" style="display: none;">
                <li @if(Request::is('gangs/highscores')) class="active" @endif><a href="{{URL::route('gangs.highscores')}}">Highscores</a></li>
                @if ($currentUser->gang)
                	<li @if(Request::is('gangs/*/')) class="active" @endif><a href="{{ $currentUser->gang->url() }}">View Gang</a></li>
                @endif
            </ul>
        </li>
		<li @if(Request::is('weapons')) class="active" @endif><a href="{{URL::route('weapons')}}"><i class="fa fa-bullseye"></i> <span>Weapon Statistics</span></a></li>
		<li @if(Request::is('achievements')) class="active" @endif><a href="{{URL::route('achievements')}}"><i class="fa fa-flag"></i> <span>Achievements</span></a></li>

		<li><a href="https://discord.gg/bqJxheP" target="_blank"><i class="fa fa-comment"></i> <span>Discord</span></a></li>
		<li @if(Request::is('admins')) class="active" @endif><a href="{{URL::route('admins')}}"><i class="fa fa-legal"></i> <span>Admins</span></a></li>
		<li><a href="http://forum.irresistiblegaming.com" target="_blank"><i class="fa fa-comments"></i> <span>Forums</span></a></li>

	@if($currentUser->ADMINLEVEL)
		<li class="closed hasChild {{Request::is('admin/*') ? 'open active' : ''}} "><a href="javascript:;"><i class="fa fa-cogs"></i> <span>Administration</span></a>
            <ul class="acc-menu" style="display: none;">
                <li @if(Request::is('admin/search')) class="active" @endif><a href="{{URL::route('admin.search')}}">Search Account</a></li>
                <li @if(Request::is('admin/manage')) class="active" @endif><a href="{{URL::route('admin.manage')}}">Player Management</a></li>
                <li @if(Request::is('admin/transactions')) class="active" @endif><a href="{{URL::route('admin.transactions')}}">Transaction Log
                <span class="label label-info" style="margin-left: 4.5em">NEW</span></a></li><!-- destroy label soon -->
                <li @if(Request::is('admin/stats')) class="active" @endif><a href="{{URL::route('admin.stats')}}">Server Stats</a></li>
                <li @if(Request::is('admin/feedback')) class="active" @endif><a href="{{URL::route('admin.feedback')}}">Feedback</a></li>
                <li @if(Request::is('admin/logs')) class="active" @endif><a href="{{URL::route('admin.logs')}}">Admin Logs</a></li>
                <li @if(Request::is('admin/taxes')) class="active" @endif><a href="{{URL::route('admin.taxes')}}">Mapping Taxes</a></li>
            </ul>
        </li>
  	@endif
	</ul>
</nav>
