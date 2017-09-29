@extends('layout/application')

@section('page-heading')
	@if ($crowdfund->amountRaised() >= $crowdfund->FUND_TARGET)
		<h3 class="pull-right text-success" style="padding-right: 48px">Successfully funded! Estimated release {{ $crowdfund->releaseIn() }}!</h3>
	@elseif ($crowdfund->isEnded())
		<h3 class="pull-right text-danger" style="padding-right: 48px">Crowdfund unsuccessful. Users will be pending a refund.</h3>
	@endif
@stop

@section('content')
	<div class="container">
		@if (is_null($crowdfund))
			<div class="row">
				<div class="col-md-12">
					<h2 class="text-center">No crowdfunds have been intiated!</h2>
				</div>
			</div>
		@else

		<div class="row">

			<!-- Features -->
			<div class="col-md-3">

				<h3>Check out more features</h3>
				@foreach ($crowdfundData as $fund)
			    <div class="contextual-progress">
			        <div class="clearfix">
			            <div class="progress-title"><a href="{{ route('crowdfund.show', $fund->ID) }}" style="color: {{$fund->ID != $crowdfund->ID ? 'rgb(77, 77, 77)' : ($fund->amountRaised() >= $fund->FUND_TARGET ? 'rgb(133, 199, 68)' : ($fund->isEnded() ? 'rgb(168, 21, 21)' : 'rgb(43, 188, 224)'))}}">{{ $fund->FEATURE }}</a></div>
			            <div class="progress-percentage">{{ number_format($fund->pledgePercentage(), 1) }}%</div>
			        </div>
			        <div class="progress">
			            <div class="progress-bar {{ $fund->amountRaised() >= $fund->FUND_TARGET ? 'progress-bar-success' : ($fund->isEnded() ? 'progress-bar-danger' : 'progress-bar-info') }}" style="width: {{ $fund->pledgePercentage() }}%"></div>
			        </div>
			    </div>
			    @endforeach

					<!-- admin -->
					<div class="row" style="margin-top: 3em">
						<div class="col-md-12 text-center">
							<p><small class="text-muted">Crowdfunding campaigns that fail will refund all individuals involved</small></p>
							<p><small class="text-muted">There are no refunds if a campaign succeeds</small></p>
						</div>
					</div>
			</div>

			<!-- Feature details -->
			<div class="col-md-9">
				<div class="container">

					<!-- description -->
					<div class="row">
						<div class="col-md-12">
							<p class="lead">{{ $crowdfund->DESCRIPTION }}</p>
						</div>
					</div>

					<!-- contribute -->
					<div class="row">
						<!-- image -->
						<div class="col-md-4">
							<img src="{{ $crowdfund->IMAGE }}" class="img-responsive" style="min-width: 900; min-height: 600">
						</div>

						<!-- pledge information -->
						<div class="col-md-8">
						    <div class="progress">
						      <div class="progress-bar {{ $crowdfund->amountRaised() >= $crowdfund->FUND_TARGET ? 'progress-bar-success' : ($crowdfund->isEnded() ? 'progress-bar-danger' : 'progress-bar-info') }}" style="width: {{ $crowdfund->pledgePercentage() }}%"></div>
						    </div>

						    <div style="margin-bottom: 2em">
								<div style="margin-bottom: 2em">
									<h3 style="margin-bottom: -0.4em">
										{{ number_format($crowdfund->amountRaised(), 2) }} IC
										@if ( $userPledge > 0 )
											<div class="pull-right"><span class="label label-success">You pledged {{ number_format($userPledge, 2)}} IC</span></div>
										@endif
										</h3>
								 	<h3><small>pledged of {{ number_format($crowdfund->FUND_TARGET, 2) }} IC goal</small></h3>
							 	</div>

								<div>
									<h3 style="margin-bottom: -0.4em">{{ $crowdfund->endsIn() }}</h3>
								 	<h3><small>days to go</small></h3>
							 	</div>
							</div>

	                  		{{ Form::open(['route' => ['crowdfund.pledge', $crowdfund->ID], 'method' => 'post', 'class' => 'form-horizontal']) }}
							<form class="form-horizontal" action="">
							  <div class="form-group">
							    <div class="col-sm-8">
							      {{ Form::number('contribution', '', ['class' => 'form-control', 'placeholder' => "Enter coin amount", 'min' => '10', 'step' => '0.01', $crowdfund->isEnded() ? 'disabled' : '']) }}
							    </div>
							    {{ Form::submit('Contribute Coins', ['class' => 'btn btn-success col-sm-4', $crowdfund->isEnded() ? 'disabled' : ''])}}
							    <div class="col-sm-12">
							  		<small class="text-muted">You have currently {{ number_format($currentUser->COINS, 2) }} IC</small>
							  	</div>

							  </div>
							{{ Form::close() }}

						</div>
					</div>

					<!-- packages -->
					<div class="row">
						<div class="col-md-12">
							<h3>Here's what pledgers get</h3>

							@forelse ($crowdfund->packages as $package)
								<h4>{{ $package->TITLE }} <small>{{ number_format($package->REQUIRED_AMOUNT, 2) }} IC and above</small></h4>
								<p>{{ $package->DESCRIPTION }}</p>
								<p>
									@foreach ($patreons as $patreon)
										@if ($patreon->TOTAL >= $package->REQUIRED_AMOUNT)
											<span class="label {{ $currentUser->ID == $patreon->USER_ID ? 'label-primary' : 'label-default' }}">{{ $patreon->user->NAME }}</span>
										@endif
									@endforeach
								</p>
								<br>
							@empty
								<h4>Nothing but love :(</h4>
							@endforelse
						</div>
					</div>

					<hr>
				    <div class="row" >
				        <div class="col-md-12">
				            <div class="panel panel-grey" id="accordion">

								<a data-toggle="collapse" data-parent="#accordion" href="#patreons">
									<div class="panel-heading">
										<h4>Show all patreons for this feature</h4>
									</div>
								</a>

				                <div id="patreons" class="panel-collapse collapse">
					                <div class="panel-body panel-stats" style="max-height:400px; overflow:auto;">
					                @if(!count($patreons))
					                    <div align="center" class="text-muted" style="padding:2em">Nobody has contributed yet, be the first!</div>
					                @else
					                    <table class="table table-stats table-hover">
					                        <thead>
					                            <tr>
					                                <td><strong>User</strong></td>
					                                <td><strong>Total Contribution</strong></td>
					                                <td><strong>In-game Status</strong></td>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        @foreach($patreons as $key)
					                            <tr>
					                                @if ($key->user)
					                                    <td>{{{$key->user->NAME}}}</td>
					                                @else
					                                    <td style="color: red"><strong>User Does Not Exist</strong></td>
					                                @endif
					                                <td>{{ number_format($key->TOTAL, 2) }} IC</td>
					                                @if ($key->user && $key->user->ONLINE)
					                                    <td style="color: green"><strong>online</strong></td>
					                                @else
					                                    <td style="color: red"><strong>offline</strong></td>
					                               	@endif
					                            </tr>
					                        @endforeach
					                        </tbody>
					                    </table>
					                @endif
					                </div>
					            </div>
				            </div>

				            @if ($currentUser->ID == Config::get('irresistible.owner') && ! $crowdfund->isReleased())
				            	<a href="#" data-url="{{ route('crowdfund.refund', $crowdfund->ID ) }}" class="btn btn-block btn-lg btn-danger" id="refundPeople">Refund All Patreons</a>
				            @endif
				        </div>
				    </div>


				</div>

			</div>

		</div>



	@endif
	</div>
@endsection

@section ('jscontent')
<script type="text/javascript">
	$('#refundPeople').click(function (e) {
		e.preventDefault();
		if (window.confirm("Are you sure that you want to refund everyone?")) {
			window.location.href = $(this).data('url');
		}
	});
</script>
@endsection
