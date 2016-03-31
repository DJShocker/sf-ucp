@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-danger">
                <div class="panel-heading"><i class="fa fa-lock"></i> Ban Player</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/ban', 'method' => 'post'))}}

                   		<p>{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}</p>

                   		<p>{{Form::label('reason', 'Reason', array('class' => 'control-label'))}}
	            		{{Form::text('reason', '', array('class' => 'form-control'))}}</p>

                        <br/><div align="center">{{Form::submit('Ban Player', array('class' => 'btn btn-danger'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>

		<div class="col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading"><i class="fa fa-lock"></i> Army-Warn Player</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/armyban', 'method' => 'post'))}}
                   		{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}
                        <br/><div align="center">{{Form::submit('Army-Warn Player', array('class' => 'btn btn-danger'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>

		<div class="col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading"><i class="fa fa-lock"></i> Cop-Warn Player</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/copban', 'method' => 'post'))}}
                   		{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}
                        <br/><div align="center">{{Form::submit('Cop-Warn Player', array('class' => 'btn btn-danger'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-unlock"></i> Unban Player</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/unban', 'method' => 'post'))}}
                   		<p>{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}</p>

                   		<p>{{Form::label('name', 'IP Address (optional)', array('class' => 'control-label'))}}
	            		{{Form::text('ip', '', array('class' => 'form-control'))}}</p>
                        <br/><div align="center">{{Form::submit('Unban Player', array('class' => 'btn btn-success'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>

		<div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-unlock"></i> Un-Army-Warn Player</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/unarmyban', 'method' => 'post'))}}
                   		{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}
                        <br/><div align="center">{{Form::submit('Un-Army-Warn Player', array('class' => 'btn btn-success'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>

		<div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-unlock"></i> Un-Cop-Warn Player</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/uncopban', 'method' => 'post'))}}
                   		{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}
                        <br/><div align="center">{{Form::submit('Un-Cop-Warn Player', array('class' => 'btn btn-success'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-edit"></i> Change Account Password</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/password', 'method' => 'post'))}}
                   		<p>{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}</p>

                   		<p>{{Form::label('password', 'New Password', array('class' => 'control-label'))}}
	            		{{Form::text('password', '', array('class' => 'form-control'))}}</p>
                        <br/><div align="center">{{Form::submit('Change Password', array('class' => 'btn btn-primary'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>

		<div class="col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading"><i class="fa fa-eye-slash"></i> Jail Player</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/jail' , 'method' => 'post'))}}
                   		<p>{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}</p>

                   		<p>{{Form::label('seconds', 'Seconds', array('class' => 'control-label'))}}
	            		{{Form::text('seconds', '', array('class' => 'form-control'))}}</p>
                        <br/><div align="center">{{Form::submit('Jail Player', array('class' => 'btn btn-warning'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>

		<div class="col-md-4">
            <div class="panel panel-inverse">
                <div class="panel-heading"><i class="fa fa-times-circle-o"></i> Mute Player</div>
                <div class="panel-body">
                    {{Form::open(array('url' => '/admin/manage/mute' , 'method' => 'post'))}}
                   		<p>{{Form::label('name', 'Name', array('class' => 'control-label'))}}
	            		{{Form::text('name', '', array('class' => 'form-control'))}}</p>

                   		<p>{{Form::label('seconds', 'Seconds', array('class' => 'control-label'))}}
	            		{{Form::text('seconds', '', array('class' => 'form-control'))}}</p>
                        <br/><div align="center">{{Form::submit('Mute Player', array('class' => 'btn btn-inverse'))}}</div>
                    {{ Form::close(); }}
                </div>
            </div>
		</div>
	</div>

</div>
@stop