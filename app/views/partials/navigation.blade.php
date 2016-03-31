<header class="navbar navbar-inverse navbar-static-top" role="banner">
  <a id="leftmenu-trigger" class="tooltips" title="" data-placement="right" data-toggle="tooltip" data-original-title="Toggle Sidebar"></a>
    
  <ul class="nav navbar-nav pull-right toolbar">
    <li class="dropdown">
      <a id="rightmenu-trigger" href="#" class="dropdown-toggle" data-toggle="dropdown"></a>
      <ul class="dropdown-menu userinfo" class="float:right">
        <li class="username">
          <a href="#">
            <div class="text-center"><h5>Good day to you, <span>{{{$currentUser->NAME}}}!</span></h5></div>
          </a>
        </li>
        <li class="userlinks">
          <ul class="dropdown-menu">
            <li><a href="http://forum.irresistiblegaming.com" target="_blank">Main Site <i class="pull-right fa fa-group"></i></a></li>
            <li><a href="http://donate.irresistiblegaming.com" target="_blank">Donate <i class="pull-right fa fa-money"></i></a></li>
            <li><a href="{{URL::to('/help')}}">Help Centre <i class="pull-right fa fa-question-circle"></i></a></li>
            <li class="divider"></li>
            <li><a href="{{URL::to('/auth/destroy')}}" class="text-right">Sign Out</a></li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>

  <div class="navbar-header pull-left">
      <a class="navbar-brand" href="/dashboard">SF-UCP</a>
  </div>

  <ul class="nav navbar-nav pull-right toolbar">
    <li class="dropdown">
      <a href="#" class="hidden-xs">{{{$currentUser->NAME}}}</a>
    </li>
  </ul>
</header>