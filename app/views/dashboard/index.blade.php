@extends('layout/application')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <a class="info-tiles tiles-success" href="{{URL::to('help')}}">
                        <div class="tiles-heading">Cash at bank and on-hand</div>
                        <div class="tiles-body-alt">
                            <!--i class="fa fa-bar-chart-o"></i-->
                            <div class="text-center"><span class="text-top">$</span>{{number_format($currentUser->CASH + $currentUser->BANKMONEY)}}</div>
                            <small>
                                @if(($currentUser->CASH < $currentUser->BANKMONEY && !$currentUser->BANKMONEY) || ($currentUser->CASH > $currentUser->BANKMONEY && !$currentUser->CASH))
                                    100.0%
                                @elseif(!$currentUser->CASH AND !$currentUser->BANKMONEY)
                                	0.0%
                                @else
                                    {{$currentUser->CASH > $currentUser->BANKMONEY ? sprintf('%.1f%%', abs($currentUser->BANKMONEY / ($currentUser->CASH))*100) : sprintf('%.1f%%', abs($currentUser->CASH / ($currentUser->BANKMONEY))*100) }}
                                @endif
                                Being {{$currentUser->CASH < $currentUser->BANKMONEY ? ('On-Hand') : ('Banked')}}
                            </small>
                        </div>
                        <div class="tiles-footer">knowledge is power, and you can't buy it!</div>
                    </a>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <a class="info-tiles tiles-primary" href="{{URL::to('economics')}}">
                        <div class="tiles-heading">Economics</div>
                        <div class="tiles-body-alt">
                            <i class="fa fa-money"></i>
                            <div class="text-center">{{$taxRate}}</div>
                            <small>Current Tax Rate</small>
                        </div>
                        <div class="tiles-footer">visit the economics center!</div>
                    </a>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <a class="info-tiles tiles-toyo" href="samp://svr.irresistiblegaming.com:7777">
                        <div class="tiles-heading">Server Status</div>
                        <div class="tiles-body-alt">
                            <i class="fa fa-group"></i>
                            <div class="text-center">{{$serverPlayers}}</div>
                            <small>Players Online</small>
                        </div>
                        <div class="tiles-footer">join the fun today!</div>
                    </a>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <a class="info-tiles tiles-orange" href="http://donate.irresistiblegaming.com">
                        <div class="tiles-heading">VIP Status</div>
                        <div class="tiles-body-alt">
                            <i class="fa fa-star"></i>
                            @if($currentUser->VIP_PACKAGE)
                                <div class="text-center">{{Gliee\Irresistible\Utils::vipToString($currentUser->VIP_PACKAGE)}}</div>
                                <small>Expires {{$vipExpiry or 'Never'}}</small>
                            @else
                                <div class="text-center">None :(</div>
                                <small>No VIP Active</small>
                            @endif
                        </div>
                        <div class="tiles-footer">{{$currentUser->VIP_PACKAGE ? 'you can always donate to renew!' : 'donate today and redeem vip!'}}</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4>Total Money Being Printed</h4>
                </div>
                <div class="panel-body">
                    <div id="cashPrinted" style="height: 300px"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-midnightblue">
                <div class="panel-heading">
                    <h4><i class="fa fa-wrench"></i> General Statistics</h4>
                </div>
                <div class="panel-body panel-stats">
                    <table class="table table-stats table-hover">
                        <tbody>
                            <tr>
                                <td>Admin Level</td>
                                <td>{{Gliee\Irresistible\Utils::adminlevelToString($currentUser->ADMINLEVEL)}}</td>
                            </tr>
                            <tr>
                                <td>Total Irresistible Coins</td>
                                <td>{{$currentUser->COINS}} <a href="//donate.irresistiblegaming.com"><span class="label label-primary pull-right">Get more!</span></a></td>
                            <tr>
                                <td>Time Online</td>
                                <td>{{$timeOnline}}</td>
                            </tr>
                            <tr>
                                <td>Weekly Playtime</td>
                                <td>{{$timeOnlineWeekly}}</td>
                            </tr>
                            <tr>
                                <td>Cop-Banned</td>
                                <td>{{$currentUser->COP_BAN >= 3 ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <td>Army-Banned</td>
                                <td>{{$currentUser->ARMY_BAN >= 3 ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <td>Muted Time</td>
                                <td>{{$mutedTime or 'Not Muted'}}</td>
                            </tr>
                            <tr>
                                <td>Jail Time</td>
                                <td>{{$jailedTime or 'Not Jailed'}} @if($jailedTime > 0 AND $currentUser->JAIL_ADMIN == true)<span class="label label-danger pull-right">ADMIN JAILED</span>@endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-brown">
                <div class="panel-heading">
                    <h4><i class="fa fa-gamepad"></i> Game Statistics</h4>
                </div>
                <div class="panel-body panel-stats">
                    <table class="table table-stats table-hover">
                        <tbody>
                            <tr>
                                <td>Job</td>
                                <td>{{Gliee\Irresistible\Utils::skillToString($currentUser->JOB)}}</td>
                            </tr>
                            <tr>
                                <td>VIP Job</td>
                                <td>
                                    @if ($currentUser->VIP_PACKAGE <= 0)
                                        <a href="//donate.irresistiblegaming.com">You are not a VIP, become one today!</a>
                                    @else
                                        {{Gliee\Irresistible\Utils::skillToString($currentUser->VIP_JOB)}}</td>
                                    @endif
                            </tr>
                            <tr>
                                <td>Score</td>
                                <td>{{number_format($currentUser->SCORE)}}</td>
                            </tr>
                            <tr>
                                <td>XP</td>
                                <td>{{number_format($currentUser->XP)}}</td>
                            </tr>
                            <tr>
                                <td>Cash On-Hand</td>
                                <td>${{number_format($currentUser->CASH)}}</td>
                            </tr>
                            <tr>
                                <td>Cash At Bank</td>
                                <td>${{number_format($currentUser->BANKMONEY)}}</td>
                            </tr>
                            <tr>
                                <td>Kills</td>
                                <td>{{number_format($currentUser->KILLS)}}</td>
                            </tr>
                            <tr>
                                <td>Deaths</td>
                                <td>{{number_format($currentUser->DEATHS)}}</td>
                            </tr>
                            <tr>
                                <td>K/D Ratio</td>
                                <td>{{$kdRatio}}</td>
                            </tr>
                            <tr>
                                <td>Owned Houses</td>
                                <td>{{$currentUser->OWNEDHOUSES}}</td>
                            </tr>
                            <tr>
                                <td>Owned Vehicles</td>
                                <td>{{$currentUser->OWNEDCARS}}</td>
                            </tr>
                            <tr>
                                <td>Owned Garages</td>
                                <td>{{$numberGarages}}</td>
                            </tr>
                            <tr>
                                <td>Total Arrests</td>
                                <td>{{number_format($currentUser->ARRESTS)}}</td>
                            </tr>
                            <tr>
                                <td>Total Robberies</td>
                                <td>{{number_format($currentUser->ROBBERIES)}}</td>
                            </tr>
                            <tr>
                                <td>Total Extinguished Fires</td>
                                <td>{{number_format($currentUser->FIRES)}}</td>
                            </tr>
                            <tr>
                                <td>Total Completed Hits</td>
                                <td>{{number_format($currentUser->CONTRACTS)}}</td>
                            </tr>
                            <tr>
                                <td>Total Burglaries</td>
                                <td>{{number_format($currentUser->BURGLARIES)}}</td>
                            </tr>
                            <tr>
                                <td>Total Cars Jacked</td>
                                <td>{{number_format($currentUser->VEHICLES_JACKED)}}</td>
                            </tr>
                            <tr>
                                <td>Total Meth Yielded</td>
                                <td>{{number_format($currentUser->METH_YIELDED)}}</td>
                            </tr>
                            <tr>
                                <td>Blew Bank Vault</td>
                                <td>{{number_format($currentUser->BLEW_VAULT)}}</td>
                            </tr>
                            <tr>
                                <td>Blew Jail Cells</td>
                                <td>{{number_format($currentUser->BLEW_JAILS)}}</td>
                            </tr>
                            <tr>
                                <td>Total Trucked Cargo</td>
                                <td>{{number_format($currentUser->TRUCKED)}}</td>
                            </tr>
                            <tr>
                                <td>Current Bounty</td>
                                <td>${{number_format($currentUser->BOUNTY)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4><i class="fa fa-shopping-cart"></i> Item Statistics</h4>
                </div>
                <div class="panel-body panel-stats">
                    <table class="table table-stats table-hover">
                        <tbody>
                            <tr>
                                <td>Rope</td>
                                <td>{{$currentUser->ROPES}}</td>
                            </tr>
                            <tr>
                                <td>Metal Melters</td>
                                <td>{{$currentUser->MELTERS}}</td>
                            </tr>
                            <tr>
                                <td>Scissors</td>
                                <td>{{$currentUser->SCISSORS}}</td>
                            </tr>
                            <tr>
                                <td>Weed</td>
                                <td>{{$currentUser->WEED}} grams</td>
                            </tr>
                            <tr>
                                <td>Aluminum Foil</td>
                                <td>{{$currentUser->FOILS}}</td>
                            </tr>
                            <tr>
                                <td>Bobby Pins</td>
                                <td>{{$currentUser->PINS}}</td>
                            </tr>
                            <tr>
                                <td>C4</td>
                                <td>{{$currentUser->C4}}</td>
                            </tr>
                            <tr>
                                <td>Caustic Soda</td>
                                <td>{{$currentUser->SODA}}</td>
                            </tr>
                            <tr>
                                <td>Muriatic Acid</td>
                                <td>{{$currentUser->ACID}}</td>
                            </tr>
                            <tr>
                                <td>Hydrogen Chloride</td>
                                <td>{{$currentUser->GAS}}</td>
                            </tr>
                            <tr>
                                <td>Methamphetamine (meth)</td>
                                <td>{{$currentUser->METH}} pounds</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 hidden-xs">
            <div class="panel panel-primary">
                <div class="panel-heading">User Statistics <small class="pull-right"><strong>This link shows the raw image:</strong> {{URL::to('/')}}/sig/{{$currentUser->ID}}</small></div>
                <div class="panel-body">
                    <div align="center"><img src="{{URL::to('/')}}/sig/{{$currentUser->ID}}" class="img-responsive"><!--<h4><span class="label label-default">?bg={url}</span> is used to specify the URL of the background, PNG only!</h4>--></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('jscontent')
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.min.js'></script>
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.resize.min.js'></script>
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.time.min.js'></script>
<script type='text/javascript' src='assets/js/economics-flotgraph.js'></script>
@stop
