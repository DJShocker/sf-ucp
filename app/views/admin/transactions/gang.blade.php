@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-2">
            {{Form::open(array('route' => 'admin.trans.gang.search', 'method' => 'POST'))}}
            	<h3>Search Transaction Log</h3>

				<div class="form-group">
					{{Form::label('searchType', 'Search Type', array('class' => 'control-label'))}}
	            	{{Form::select('searchType', [0 => 'Money'], 0, array('class' => 'form-control', 'disabled' => 'disabled'))}}
	            </div>

				<div class="form-group">
					{{Form::label('username', 'Username', array('class' => 'control-label'))}}
	            	{{Form::text('username', trim(strip_tags(Input::get('username'))), array('class' => 'form-control', 'placeholder' => 'Username'))}}
	            </div>

				<div class="form-group">
					{{Form::label('gangname', 'From Gang', array('class' => 'control-label'))}}
	            	{{Form::text('gangname', trim(strip_tags(Input::get('gangname'))), array('class' => 'form-control', 'placeholder' => 'Gang (optional)'))}}
	            </div>

	            <div align="center">
		         	<p>{{Form::submit('Search Logs', array('class' => 'btn btn-success'))}}</p>
	            </div>
            {{Form::close()}}
		</div>
		<div class="col-md-10">
		    <div class="table-responsive">
		        <table class="table">
		          	<thead>
					    <tr>
	                        <th>To Name</th>
	                        <th>From Gang</th>
	                        <th>Amount</th>
	                        <th>Nature</th>
	                        <th>Date</th>
					    </tr>
				    </thead>

				    <tbody>
		           	@forelse ($transactionsLog as $key)
		                <tr>
		                	<td>{{$key->toUser->NAME or "<i>Invalid User</i>"}}</td>
		                	<td>
		                		@if ($key->fromGang)
		                			<a href="{{ $key->fromGang->url() }}" target="_blank"><span class="label label-primary" style="font-size: 14px">{{ $key->fromGang->NAME }}</span></a>
		                		@else
		                			<i>Invalid Gang</i>
		                		@endif
		                	</td>
		                	<td>{{isset($key->CASH) ? '$' . number_format($key->CASH) : $key->IC}}</td>
		                	<td>{{{$key->NATURE}}}</td>
		                	<td>{{$key->DATE}}</td>
		                </tr>
		          	@empty
		          		<tr>
		          			<td colspan="4" class="h3 text-center"><br>No transactions could be found!</td>
		          		</tr>
		         	@endforelse
				    </tbody>
			    </table>
		    </div>

		    <div class="text-center">{{ $transactionsLog->appends(['searchType' => trim(Input::get('searchType')), 'toName' => trim(Input::get('toName')), 'fromName' => Input::get('fromName')])->links() }}</div>
		</div>
	</div>
</div>
@stop
