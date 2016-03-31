@extends('layout/application')

@section('content')    
<div class="container">

      {{Form::open(['url' => '/help/create', 'method' => 'POST'])}}
		<div class="row">
	   		<div class="col-md-6">
	   			{{Form::text('subject', '', array('class' => 'form-control', 'placeholder' => 'Enter Subject/Title Here'))}}
	   		</div>

	   		<br class="hidden-md hidden-lg" />

	   		<div class="col-md-6">
		        <select name="category" class="form-control">
		            <option value="">Choose A Category</option>
		            <option value="0">Server Information</option>
		            <option value="1">Help</option>
		            <option value="2">FAQ</option>
		            <option value="3">Guides</option>
		            <option value="4">Tips n' Tricks</option>
		        </select>
	        </div>
	   	</div>

	   	<br/>

	   	<div class="row">
	       	<div class="col-md-12">
	    		{{Form::textarea('content', '', array('class' => 'ckeditor'))}}
    		</div> 		
	   	</div>

	   	<br/>

	   	<div class="row">
	   		<div class="col-md-12">	   		
	        	<div class="text-center">{{Form::submit('Submit Thread', array( 'class' => 'btn btn-lg btn-success'))}}</div>
	   		</div>
	   	</div>
      {{Form::close()}}
	</div>
</div>
@stop

@section('jscontent')
<script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/form-ckeditor/ckeditor.js'></script>
@stop