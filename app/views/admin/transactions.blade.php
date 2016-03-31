@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-offset-4 col-md-4">
            {{Form::open(array('route' => 'admin.trans.search', 'method' => 'POST'))}}
            	<h3>Search Transaction Log</h3>

				<div class="form-group">
					{{Form::label('searchType', 'Search Type', array('class' => 'control-label'))}}
	            	{{Form::select('searchType', ['Money', 'Irresistible Coins'], 0, array('class' => 'form-control'))}}
	            </div>

				<div class="form-group">
					{{Form::label('toName', 'To Username', array('class' => 'control-label'))}}
	            	{{Form::text('toName', '', array('class' => 'form-control'))}}
	            </div>

				<div class="form-group">
					{{Form::label('fromName', 'From Username', array('class' => 'control-label'))}}
	            	{{Form::text('fromName', '', array('class' => 'form-control'))}}
	            </div>

	            <div align="center">
		         	<p>{{Form::submit('Search Logs', array('class' => 'btn btn-success'))}}</p>
	            </div>
            {{Form::close()}}
		</div>
	</div>
</div>
@stop
