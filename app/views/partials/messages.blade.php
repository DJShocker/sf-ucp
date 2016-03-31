@if(count($errors->all()))
	<div class="alert alert-container alert-dismissable alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         @foreach($errors->all() as $message)
            <p>{{$message}}</p>
         @endforeach
    </div>
@endif

@if(Session::has('success'))
	<div class="alert alert-container alert-dismissable alert-success">
    	{{Session::get('success')}}
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    </div>
@endif