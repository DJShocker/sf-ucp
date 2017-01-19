@extends('layout/application')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-stats table-hover">
                <thead>
                    <tr>
                        <td class="col-sm-2"><strong>User</strong></td>
                        <td class="col-sm-1"><strong>Score</strong></td>
                        <td class="col-sm-6"><strong>Feedback</strong></td>
                        <td class="col-sm-2"><strong>Date</strong></td>
                    </tr>
                </thead>
                <tbody>
                @forelse ($feedback as $key)
                	<tr id="{{ $key->ID }}">
                		@if ($key->user)
                		<td>{{ $key->user->NAME }}</td>
                		<td>{{ $key->user->SCORE }}</td>
                		@else
                		<td style="color: red; font-weight: 400">Not Found</td>
                		<td style="color: red; font-weight: 400">n/a</td>
                		@endif
                		<td>{{{ $key->FEEDBACK }}}</td>
                		<td>{{ $key->DATE->diffForHumans() }}
                		<td><a href="#" data-url="/api/player/feedback/{{ $key->ID }}" class="destroyFeedback">Delete</a></td>
                	</td>
                @empty
                	<td colspan="4" class="text-center"><h3>No feedback to show</h3></td>
               	@endforelse
                </tbody>
            </table>
	    </div>
	</div>
</div>

@stop

@section ('jscontent')
<script type="text/javascript">
	$('.destroyFeedback').click(function (e) {
		e.preventDefault();
		$(this).closest('tr').fadeOut(1000);

		//if (window.confirm("Are you sure that you wish to remove this feedback?")) {
	    	var like = $.ajax($(this).data('url')).done(function()
	    	{
	        	var data = $.parseJSON(like['responseText']);

	        	if (data.status != "deleted") {
	        		alert("Couldn't delete feedback. Refresh page.");
	  				$("tr[id=" + data.id +"]").fadeIn();
	        	}
	    	});
	    //}
	});
</script>
@stop
