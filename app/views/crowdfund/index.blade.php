@extends('layout/application')


@section('content')
	<div class="container">
		<div class="row">


			<div class="col-md-12">

				@forelse ($crowdfundData as $fund)
			    <div class="panel panel-gray">
			      <div class="panel-body">
			      	<div class="row">
			      		<div class="col-md-12">
						    <div class="contextual-progress">
						        <div class="clearfix">
						            <div class="progress-title"><a href="{{ route('crowdfund.show', $fund->ID) }}" style="color: rgb(77, 77, 77)">{{ $fund->FEATURE }}</a></div>
						            <div class="progress-percentage">{{ number_format($fund->pledgePercentage(), 1) }}% funded &bullet; {{ $fund->patreons->count() }} {{ $fund->patreons->count() > 1 ? 'backers' : 'backer' }}</div>
						        </div>
						        <div class="progress">
						            <div class="progress-bar {{ $fund->amountRaised() > $fund->FUND_TARGET ? 'progress-bar-success' : ($fund->isEnded() ? 'progress-bar-danger' : 'progress-bar-info') }}" style="width: {{ $fund->pledgePercentage() }}%"></div>
						        </div>
						    </div>
			      		</div>
			      	</div>
			      	<div class="row">
			      		<div class="col-md-10">
						    <p class="small text-muted" style="margin-bottom: 0">{{ $fund->DESCRIPTION }}</p>
			      		</div>
			      		<div class="col-md-2">
			      			<a href="{{ route('crowdfund.show', $fund->ID) }}" class="btn btn-xs btn-primary btn-block">See more...</a>
			      		</div>
			      	</div>
			      </div>
			    </div>
			    @empty
			    <p class="text-danger">Nothing to show</p>
			    @endforelse

	   		</div>
	   	</div>

		<!-- admin -->
		<div class="row" style="margin-top: 3em">
			<div class="col-md-offset-2 col-md-8 text-center">
				<p><small class="text-muted">Crowdfunding campaigns that fail will refund all individuals involved</small></p>
				<p><small class="text-muted">There are no refunds if a campaign succeeds</small></p>
			</div>
		</div>

	</div>

@endsection
