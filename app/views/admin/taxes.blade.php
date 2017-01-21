@extends('layout/application')

@section('content')
<div class="container">

	<div class="row">
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4><i class="fa fa-home"></i> Mapping Taxes</h4>
                </div>
                <div class="panel-body panel-stats" style="height: 300px; overflow:auto;">
                    <table class="table table-stats table-hover">
                        <tbody>
                            <tr style="color: green">
                                <td>Today (IC)</td>
                                <td>{{ number_format($mapTaxReceiptsDay->sum('COINS')) }} IC</td>
                            </tr>
                            <tr>
                                <td>This Week (IC)</td>
                                <td>{{ number_format($mapTaxReceiptsWeek->sum('COINS')) }} IC</td>
                            </tr>
                            <tr>
                                <td>This Month (IC)</td>
                                <td>{{ number_format($mapTaxReceiptsMonth->sum('COINS')) }} IC</td>
                            </tr>
                            <tr style="color: green">
                                <td>Today ($)</td>
                                <td>${{ number_format($mapTaxReceiptsDay->sum('CASH')) }}</td>
                            </tr>
                            <tr>
                                <td>This Week ($)</td>
                                <td>${{ number_format($mapTaxReceiptsWeek->sum('CASH')) }}</td>
                            </tr>
                            <tr>
                                <td>This Month ($)</td>
                                <td>${{ number_format($mapTaxReceiptsMonth->sum('CASH')) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
        <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-check"></i> Mapping Taxes Paid Recently</div>
                <div class="panel-body panel-stats" style="height: 300px; overflow:auto;">
                @if (! count($mapTaxReceiptsWeek))
                    <div align="center" style="padding-top:125px"><h1>There's no recent mapping taxes paid.</h1></div>
                @else
                    <table class="table table-stats table-hover">
                        <thead>
                            <tr>
                                <td><strong>ID</strong></td>
                                <td><strong>User</strong></td>
                                <td><strong>Amount</strong></td>
                                <td><strong>Time Ago</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($mapTaxReceiptsWeek as $key)
                            <tr>
			            		@if ($key->MAPPING_ID == -1)
			            		<td class="text-info"><small>All Maps</small></td>
			            		@else
			            		<td>{{ $key->MAPPING_ID }}</td>
			            		@endif

			            		@if ($key->user)
			            		<td>{{ $key->user->NAME }}</td>
			            		@else
			            		<td style="color: red; font-weight: 400">User Not Found</td>
			            		@endif

			            		@if ( !$key->CASH)
                                	<td>{{ number_format($key->COINS) }} IC</td>
                                @else
                                	<td>${{ number_format($key->CASH) }}</td>
                                @endif

                                <td>{{ $key->renewed() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                </div>
            </div>
        </div>
    </div>


	<div class="row">
        <div class="col-md-12">


            <div class="panel panel-danger">
                <div class="panel-heading"><i class="fa fa-exclamation-circle"></i> Mapping Taxes Due Within A Month</div>
                <div class="panel-body panel-stats" style="height:400px; overflow:auto;">
                @if (! count($mapTaxes))
                    <div align="center" style="padding-top:125px"><h1>There are no mapping taxes due within a month.</h1></div>
                @else
                    <table class="table table-stats table-hover">
                        <thead>
                            <tr>
                                <td><strong>ID</strong></td>
                                <td><strong>User</strong></td>
                                <td><strong>Objects</strong></td>
                                <td><strong>Cost</strong></td>
                                <td><strong>Description</strong></td>
                                <td><strong>Coordinates</strong></td>
                                <td><strong>Due Date</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($mapTaxes as $key)
                            <tr>
                                <td>{{ $key->ID }}</td>
			            		@if ($key->user)
			            		<td>{{ $key->user->NAME }}</td>
			            		@else
			            		<td style="color: red; font-weight: 400">Not Found</td>
			            		@endif
                                <td>{{ $key->OBJECTS }}</td>
                                <td>{{ sprintf("%.2f", $key->OBJECTS * $key->COST) }} IC</td>
                                <td>{{{ $key->DESCRIPTION }}}</td>
                                <td><small>{{ $key->X }} {{ $key->Y }} {{ $key->Z }}</small></td>
                                <td>{{ $key->expiry() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                </div>
            </div>

        </div>
	</div>
</div>
@stop


@section('jscontent')
<script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/charts-flot/jquery.flot.min.js'></script>
<script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/charts-flot/jquery.flot.resize.min.js'></script>
<script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/charts-flot/jquery.flot.time.min.js'></script>
<script type="text/javascript" src="{{URL::to('/')}}/assets/js/angular.min.js"></script>
<script type='text/javascript' src='{{URL::to('/')}}/assets/js/flotgraphTaxes.js'></script>
@stop
