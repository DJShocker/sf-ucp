@extends('layout/application')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        	<p class="text-center">There are currently a total of {{$totalAdmins}} administrators with an average weekly playtime of {{Gliee\Irresistible\Utils::secondstohuman($averageUptime)}}.</p>
        	<div class="table-responsive">
	            <table class="table">
	                <thead>
	                    <tr>
	                        <th>Name</th>
	                        <th>Admin Level/Rank</th>
	                        <th>Last Logged</th>
	                        <th>Weekly Playtime</th>
	                        <th>Last Promotion/Demotion</th>
	                    </tr>
	                </thead>
	                <tbody>						
						<tr>
							<td>Lorenc</td>
							<td><font color="#FF6200"><strong>Developer</strong></font></td>
							<td>n/a</td>
							<td>n/a</td>
							<td></td>
						</tr>

						<tr>
							<td>XFlawless</td>
							<td><font color="#FF6200"><strong>Developer</strong></font></td>
							<td>n/a</td>
							<td>n/a</td>
							<td></td>
						</tr>

						@foreach($adminList as $user)
							@if($user->NAME != "XFlawless" && $user->NAME != "Lorenc")
								<tr>
									<td>{{ucfirst($user->NAME)}}</td>
		                        	<td>{{Gliee\Irresistible\Utils::adminlevelToString($user->ADMINLEVEL)}}</td>
		                        	<td>{{Carbon\Carbon::createFromTimeStamp($user->LASTLOGGED)->diffForHumans()}}</td>
		                        	<td>{{Gliee\Irresistible\Utils::secondstohuman($user->UPTIME - $user->WEEKEND_UPTIME)}}</td>
									<td>
										@if ($user->adminlog->isEmpty() == false)
											<?php
												$carbonDate = new Carbon\Carbon($user->adminlog[0]->DATE);
												$color = "green";

												if (isset($user->adminlog[1]) && is_null($user->adminlog[1]) == false && $user->adminlog[1]->LEVEL > $user->adminlog[0]->LEVEL) {
													$color = "red";
												}

												echo "<font style='color: {$color}'>{$carbonDate->toDayDateTimeString()}</font>";
											?>
										@endif
									</td>
								</tr>
							@endif
						@endforeach
	                </tbody>
	            </table>
            </div>
        </div>
    </div>
</div>

@stop