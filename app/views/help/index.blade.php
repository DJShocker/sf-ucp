@extends('layout/application')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-green">
				<div class="panel-heading">
					<h4>Did you know?</h4>
				</div>
				<div class="panel-body">
					<p>You can view all these topics and threads in-game by the command <strong>/help</strong>.</p>
					<p>Admins (level 3+) are able to write threads, to help you all if need be.</p>
				</div>
			</div>

			@if($currentUser->ADMINLEVEL > 3)
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4><i class="fa fa-book"></i> Create a new thread?</h4>
				</div>
				<div class="panel-body">
                    <p>Ensure no obscene/vulgar content is written and all is typed flawlessly, as what you type is featured in-game.</p>
                    <p>Only plain text can be used, meaning no media or any HTML code. In addition, to colour, you may use {RRGGBB} for colouring (hex colour codes).</p>
                    <div align="center"><a href="help/write" class="btn btn-primary">Get Started <i class="m-icon-swapright m-icon"></i></a></div>
				</div>
			</div>
			@endif
		</div>
		<div class="col-md-9">
			<div class="panel-group" id="accordion">
	      		@if(!$helpTopics->isEmpty())
					@foreach($helpTopics as $key)
					<div class="panel panel-grey">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$key->ID}}">
							<div class="panel-heading">
								<h4>{{$key->SUBJECT}} <small style="color: #eee">by {{{$key->author['NAME'] or 'Unknown'}}}</small></h4>
								<div class="pull-right hidden-xs hidden-sm">{{Gliee\Irresistible\Utils::helpTopicColor($key->CATEGORY)}}</div>
							</div>
						</a>
						<div id="collapse_{{$key->ID}}" class="panel-collapse collapse">
							<div class="panel-body">
								{{$key->CONTENT}}

								@if($key->USER_ID == $currentUser->ID OR $currentUser->ADMINLEVEL > 4)
								{{Form::open(array('url' => '/help/destroy', 'method' => 'POST'))}}
									<input type="hidden" name="id" value="{{$key->ID}}" />
									<div align="center">
										<a class="btn btn-sm btn-primary" href="/help/{{$key->ID}}/edit">Edit Topic</a>
										<input class="btn btn-sm btn-danger" type="Submit" value="Delete Topic"/>
									</div>
								{{Form::close()}}
								@endif
							</div>
						</div>
					</div>
					@endforeach
				@else
	             <div align="center"><h1>Damn! No topics at the moment are written.</h1></div>
				@endif
			</div>
		</div>
	</div>
</div>
@stop
