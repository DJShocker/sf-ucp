@extends('layout/application')

@section('content')
<div class="container">

      {{Form::open(['route' => ['help.save', $topic->ID], 'method' => 'POST'])}}
		<div class="row">
	   		<div class="col-md-6">
	   			{{Form::text('subject', $topic->SUBJECT, array('class' => 'form-control', 'placeholder' => 'Enter Subject/Title Here'))}}
	   		</div>

	   		<br class="hidden-md hidden-lg" />

	   		<div class="col-md-6">
	   			{{ Form::select('category', [-1 => 'Choose A Category', 0 => 'Server Information', 1 => 'Feature', 2 => 'Help', 3 => 'FAQ', 4 => 'Guides', 5 => 'Tips n\' Tricks'], $topic->CATEGORY, ['class' => 'form-control'])}}
	        </div>
	   	</div>

	   	<br/>
	   	<div class="row">
	       	<div class="col-md-12">
	    		{{Form::textarea('content', $topic->CONTENT, array('class' => 'ckeditor'))}}
    		</div>
	   	</div>

	   	<br/>

	   	<div class="row">
	   		<div class="col-md-12">
	        	<div class="text-center">{{Form::submit('Save Thread', array( 'class' => 'btn btn-lg btn-success'))}}</div>
	   		</div>
	   	</div>
      {{Form::close()}}
	</div>
</div>
@stop

@section('jscontent')
<script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/form-ckeditor/ckeditor.js'></script>
@stop
