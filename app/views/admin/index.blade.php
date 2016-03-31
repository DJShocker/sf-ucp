@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-2">
            {{Form::open(array('route' => 'admin.player.search', 'method' => 'POST'))}}
            	<h3>Advanced Search</h3>

				<div class="form-group">
					{{Form::label('table', 'Search Through', array('class' => 'control-label'))}}
					{{Form::select('table', array('0' => 'All Users', '1' => 'Player Bans'), '0', array('class' => 'form-control'))}}
	            </div>

				<div class="form-group">
					{{Form::label('name', 'Username', array('class' => 'control-label'))}}
	            	{{Form::text('name', '', array('class' => 'form-control'))}}
	            </div>

				<div class="form-group">
					{{Form::label('ip', 'IP Address (optional)', array('class' => 'control-label'))}}
	            	{{Form::text('ip', '', array('class' => 'form-control'))}}
	            </div>

				<div class="row form-group">
					<div class="col-md-12">{{Form::label('score', 'Score Between (optional)', array('class' => 'control-label'))}}</div>
	            	<div class="col-md-6 col-sm-6 col-xs-6">{{Form::text('score-min', '', array('class' => 'form-control', 'placeholder' => 'min'))}}</div>
	            	<div class="col-md-6 col-sm-6 col-xs-6">{{Form::text('score-max', '', array('class' => 'form-control', 'placeholder' => 'max'))}}</div>
	            </div>

				<div class="row form-group">
					<div class="col-md-12">{{Form::label('cash', 'Total Cash Between (optional)', array('class' => 'control-label'))}}</div>
	            	<div class="col-md-6 col-sm-6 col-xs-6">{{Form::text('cash-min', '', array('class' => 'form-control', 'placeholder' => 'min'))}}</div>
	            	<div class="col-md-6 col-sm-6 col-xs-6">{{Form::text('cash-max', '', array('class' => 'form-control', 'placeholder' => 'max'))}}</div>
	            </div>

				<div class="form-group">
					<div class="checkbox block"><label>{{Form::checkbox('recent', '0', false)}} Order by most recent accounts</label></div>
				</div>

	            <div align="center">
		            <p>{{Form::submit('Search', array('class' => 'btn btn-success'))}}</p>
		            <p><i>Only the IP or Username field will work as you search through bans.</i></p>
	            </div>
            {{Form::close()}}
		</div>
		<div class="col-md-10">
		    <div class="table-responsive">
		        <table class="table">
		          	<thead>
					    <tr>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=name">Name</a></th>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=ip">Registered IP Address</a></th>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=lastip">Recent IP Address</a></th>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=score">Score</a></th>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=cash">On-Hand Money</a></th>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=bankcash">Bank Money</a></th>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=xp">XP</a></th>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=bounty">Current Bounty</a></th>
	                        <th><a href="{{Request::url()}}?page={{$users->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=adminlevel">Admin level</a></th>
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

			<div align="center">{{$users->appends(array('sort' => ($sort == "desc") ? "asc" : "desc", 'field' => strtolower($field) ))->links()}}</div>
		</div>
	</div>
</div>
@stop
