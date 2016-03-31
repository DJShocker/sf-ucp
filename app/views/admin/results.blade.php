@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
	@if(!count($users))
		<div class="text-center"><h2>No results found!</h2></div>
	@else
		@if($table)
		<div class="col-md-12">
		    <div class="table-responsive">
		        <table class="table">
		          	<thead>
					    <tr>
			                <th>Name</th>
			                <th>IP Address</th>
			                <th>Reason</th>
			                <th>Banned by</th>
			                <th>Date</th>
			                <th>Expires on</th>
					    </tr>
				    </thead>

				    <tbody>
		           	@foreach ($users as $user)
		                <tr>		            
	                        <td>{{ucfirst($user->NAME)}}</td>
	                        <td>{{$user->IP}}</td>
	                        <td>{{$user->REASON}}</td>
	                        <td>{{$user->BANBY}}</td>
	                        <td>{{date("jS \of F Y", $user->DATE)}}</td>
	                        <td>{{$user->EXPIRE ? date("jS \of F Y", $user->EXPIRE) : ("Never")}}</td>
		                </tr>
		         	@endforeach
				    </tbody>
			    </table>
		    </div>
		</div>

		@else
		<div class="col-md-12">
		    <div class="table-responsive">
		        <table class="table">
		          	<thead>
					    <tr>
	                        <th>Name</th>
	                        <th>Registered IP Address</th>
	                        <th>Recent IP Address</th>
	                        <th>Score</th>
	                        <th>On-Hand Money</th>
	                        <th>Bank Money</th>
	                        <th>XP</th>
	                        <th>Current Bounty</th>
	                        <th>Admin level</th>
					    </tr>
				    </thead>

				    <tbody>
		           	@foreach ($users as $user)
		                <tr>
		                    <td>{{ucfirst($user->NAME)}}</td>
		                    <td>{{$user->ADMINLEVEL >= 5 ? ("Private") : $user->IP}}</td>
		                    <td>{{$user->ADMINLEVEL >= 5 ? ("Private") : $user->LAST_IP}}</td>
		                    <td>{{$user->SCORE}}</td>
		                    <td>{{$user->CASH}}</td>
		                    <td>{{$user->BANKMONEY}}</td>
		                    <td>{{$user->XP}}</td>
		                    <td>{{$user->BOUNTY}}</td>
		                    <td>{{$user->ADMINLEVEL}}</td>
		                </tr>
		         	@endforeach
				    </tbody>
			    </table>
		    </div>
		</div>
		@endif
	@endif
		<div class="text-center" style="margin-top:50px;"><a href="{{URL::to('/admin/search')}}" class="btn btn-lg btn-inverse">Return Back?</a></div>
	</div>
</div>
@stop
