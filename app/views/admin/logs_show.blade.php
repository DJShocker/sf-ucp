@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-2">
            {{Form::open(array('route' => 'admin.log.search', 'method' => 'POST'))}}
            	<h3>Search Admin Log</h3>

				<div class="form-group">
					{{Form::label('username', 'Username', array('class' => 'control-label'))}}
	            	{{Form::text('username', trim(strip_tags(Input::get('username'))), array('class' => 'form-control', 'placeholder' => 'Username'))}}
	            </div>

				<div class="form-group">
					{{Form::label('action', 'Action', array('class' => 'control-label'))}}
	            	{{Form::text('action', trim(strip_tags(Input::get('action'))), array('class' => 'form-control', 'placeholder' => 'Action'))}}
	            </div>

				<div class="form-group">
					{{Form::label('beforeDate', 'Before Date', array('class' => 'control-label'))}}
	            	{{Form::text('beforeDate', trim(strip_tags(Input::get('beforeDate'))), array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD HH:MM:SS'))}}
	            </div>

				<div class="form-group">
					{{Form::label('fromDate', 'From Date', array('class' => 'control-label'))}}
	            	{{Form::text('fromDate', trim(strip_tags(Input::get('fromDate'))), array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD HH:MM:SS'))}}
	            </div>

	            <div align="center">
	            	<p><small class="text-center">All fields are optional</small></p>
		         	<p>{{Form::submit('Search Logs', array('class' => 'btn btn-success'))}}</p>
	            </div>
            {{Form::close()}}
		</div>
		<div class="col-md-10">
		    <div class="table-responsive">
		        <table class="table">
		          	<thead>
					    <tr>
	                        <th>Administrator</th>
	                        <th>Action</th>
	                        <th>Associated ID</th>
	                        <th>Date</th>
					    </tr>
				    </thead>
		           	@forelse ($adminLogs as $key)
		                <tr>
		            		@if ($key->user)
		            		<td>{{ $key->user->NAME }}</td>
		            		@else
		            		<td style="color: red; font-weight: 400">Not Found</td>
		            		@endif
		                	<td>{{{ $key->ACTION }}}</td>
		                	<td>{{ $key->ACTION_ID }}</td>
		                	<td>{{ $key->DATE }}</td>
		                </tr>
		          	@empty
		          		<tr>
		          			<td colspan="4" class="h3 text-center"><br>No admin logs could be found!</td>
		          		</tr>
		         	@endforelse

				    <tbody>
				    </tbody>
			    </table>
		    </div>

            <div align="center">{{ $adminLogs->appends(Input::except('_token'))->links() }}</div>
		</div>
	</div>
</div>
@stop
