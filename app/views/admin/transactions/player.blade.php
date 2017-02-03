@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-2">
            {{Form::open(array('route' => 'admin.trans.player.search', 'method' => 'POST'))}}
            	<h3>Search Transaction Log</h3>

				<div class="form-group">
					{{Form::label('searchType', 'Search Type', array('class' => 'control-label'))}}
	            	{{Form::select('searchType', ['Money', 'Irresistible Coins'], Input::get('searchType'), array('class' => 'form-control'))}}
	            </div>

				<div class="form-group">
					{{Form::label('toName', 'To Username', array('class' => 'control-label'))}}
	            	{{Form::text('toName', trim(strip_tags(Input::get('toName'))), array('class' => 'form-control'))}}
	            </div>

				<div class="form-group">
					{{Form::label('fromName', 'From Username', array('class' => 'control-label'))}}
	            	{{Form::text('fromName', trim(strip_tags(Input::get('fromName'))), array('class' => 'form-control'))}}
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
	                        <th>From Name</th>
	                        <th>Amount</th>
	                   	@if ($cashNature)
	                        <th>Nature</th>
	                    @endif
	                        <th>Date</th>
					    </tr>
				    </thead>

				    <tbody>
		           	@forelse ($transactionsLog as $key)
		                <tr>
		                	<td>{{$key->toUser->NAME or "<i>Invalid User</i>"}}</td>
		                	<td>{{$key->fromUser->NAME or "<i>Invalid User</i>"}}</td>
		                	<td>{{isset($key->CASH) ? '$' . number_format($key->CASH) : $key->IC}}</td>
		                @if ($cashNature)
		                	<td>{{{$key->NATURE}}}</td>
		                @endif
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
