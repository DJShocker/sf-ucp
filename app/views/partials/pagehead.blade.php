<div id="page-heading">
	@if(isset($breadCrumb))
	<ol class="breadcrumb">
		@foreach($breadCrumb as $index => $key)
			@if(!$index)
				<li class="active"><a href="/{{strtolower($key)}}">{{$key}}</a></li>
			@else
				<li>{{$key}}</li>
			@endif
		@endforeach
	</ol>
	@endif

	<h1>{{$pageheadTitle or "Dashboard"}}</h1>
</div>