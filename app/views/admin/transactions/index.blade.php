@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-offset-1 col-md-4">
            {{Form::open(array('route' => 'admin.trans.player.search', 'method' => 'POST'))}}
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
		         	<p>{{Form::submit('Search Player Transactions', array('class' => 'btn btn-success'))}}</p>
	            </div>
            {{Form::close()}}
		</div>
		<div class="col-md-offset-1 col-md-4">
            {{Form::open(array('route' => 'admin.trans.gang.search', 'method' => 'POST'))}}
            	<h3>Search Gang Transaction Log</h3>

				<div class="form-group">
					{{Form::label('searchType', 'Search Type', array('class' => 'control-label'))}}
	            	{{Form::select('searchType', [0 => 'Money'], 0, array('class' => 'form-control', 'disabled' => 'disabled'))}}
	            </div>

				<div class="form-group">
					{{Form::label('username', 'Username', array('class' => 'control-label'))}}
	            	{{Form::text('username', '', array('class' => 'form-control', 'placeholder' => 'Username'))}}
	            </div>

				<div class="form-group">
					{{Form::label('gangname', 'From Gang', array('class' => 'control-label'))}}
	            	{{Form::text('gangname', '', array('class' => 'form-control', 'placeholder' => 'Gang (optional)'))}}
	            </div>

	            <div align="center">
		         	<p>{{Form::submit('Search Gang Transactions', array('class' => 'btn btn-info'))}}</p>
	            </div>
            {{Form::close()}}
		</div>
	</div>
</div>
@stop

