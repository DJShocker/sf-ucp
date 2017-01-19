<nav id="page-leftbar" role="navigation">
	<ul style="" class="acc-menu" id="sidebar">
		<li @if(Request::is('dashboard')) class="active" @endif><a href="{{URL::route('dashboard')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
		<li @if(Request::is('economics')) class="active" @endif><a href="{{URL::route('economics')}}"><i class="fa fa-money"></i> <span>Economics</span></a></li>
		<li @if(Request::is('help')) class="active" @endif><a href="{{URL::route('help')}}"><i class="fa fa-info-circle"></i> <span>Help Centre</span></a></li>
		<li @if(Request::is('highscores')) class="active" @endif><a href="{{URL::route('highscores')}}"><i class="fa fa-trophy"></i> <span>Highscores</span></a></li>
		<li @if(Request::is('seasonal')) class="active" @endif><a href="{{URL::route('seasonal')}}"><i class="fa fa-leaf"></i> <span>Seasonal</span></a></li>
		<li @if(Request::is('weapons')) class="active" @endif><a href="{{URL::route('weapons')}}"><i class="fa fa-bullseye"></i> <span>Weapon Statistics</span></a></li>
		<li @if(Request::is('achievements')) class="active" @endif><a href="{{URL::route('achievements')}}"><i class="fa fa-flag"></i> <span>Achievements</span></a></li>
		<li><a href="https://kiwiirc.com/client/{{Config::get('irresistible.irc')}}/?nick={{$currentUser->NAME}}{{Config::get('irresistible.ircchan')}}" target="_blank"><i class="fa fa-comment"></i> <span>IRC</span></a></li>
		<li @if(Request::is('admins')) class="active" @endif><a href="{{URL::route('admins')}}"><i class="fa fa-legal"></i> <span>Admins</span></a></li>
		<li><a href="http://forum.irresistiblegaming.com" target="_blank"><i class="fa fa-group"></i> <span>Forums</span></a></li>

	@if($currentUser->ADMINLEVEL)
		<li class="closed hasChild {{Request::is('admin/*') ? 'open active' : ''}} "><a href="javascript:;"><i class="fa fa-cogs"></i> <span>Administration</span></a>
            <ul class="acc-menu" style="display: none;">
                <li @if(Request::is('admin/search')) class="active" @endif><a href="{{URL::route('admin.search')}}">Search Account</a></li>
                <li @if(Request::is('admin/manage')) class="active" @endif><a href="{{URL::route('admin.manage')}}">Player Management</a></li>
                <li @if(Request::is('admin/transactions')) class="active" @endif><a href="{{URL::route('admin.transactions')}}">Transaction Log</a></li>
                <li @if(Request::is('admin/stats')) class="active" @endif><a href="{{URL::route('admin.stats')}}">Server Stats</a></li>
                <li @if(Request::is('admin/feedback')) class="active" @endif><a href="{{URL::route('admin.feedback')}}">Feedback</a></li>
                <li @if(Request::is('admin/logs')) class="active" @endif><a href="{{URL::route('admin.logs')}}">Admin Logs</a></li>
            </ul>
        </li>
  	@endif
	</ul>
</nav>
