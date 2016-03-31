<?php 
	$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator); 
?>

<div class="pagination-container">		 
	@if($paginator->getLastPage() > 1)
	<ul class="pagination pagination-sm">
		{{$presenter->render()}}
	</ul>
	@endif 
</div>