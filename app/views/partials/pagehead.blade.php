<div id="page-heading">
	@if(isset($breadCrumb))
	<ol class="breadcrumb">
		@foreach($breadCrumb as $index => $key)
			@if(!$index)
				<li class="active">{{$key}}</li>
			@else
				<li>{{$key}}</li>
			@endif
		@endforeach
	</ol>
	@endif

	<h1>{{$pageheadTitle or "Dashboard"}}</h1>

	@yield ('page-heading')
</div>
