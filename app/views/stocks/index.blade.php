@extends('layout/application')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h4><span id="stock_title">test</span></h4>
                </div>
                <div class="panel-body">
                    <div id="stockGraph" style="height: 290px"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-gray">
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td><b>Stock Name</b></td>
                                <td><b>Stock Ticker</b></td>
                                <td><b>Dividend Per Share ($)</b></td>
                                <td><b>Price Per Share ($)</b></td>
                                <td><b>24 Hour Change (%)</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockReports as $report)
                            <?php
                                $previous_report = Stocks::getReport($report->STOCK_ID, 1, 2);
                                $price_change = 0.0;

                                if (count($previous_report) >= 2) {
                                    $price_change = (($previous_report[0]->PRICE / $previous_report[1]->PRICE) - 1.0) * 100.0;
                                } else {
                                    $previous_report = NULL;
                                }
                            ?>
                            <tr>
                                <td><a href="#" onclick='updateStockGraph({{$report->STOCK_ID}}, "{{ e(Stocks::$stockData[$report->STOCK_ID]['NAME']) }}")'>{{ Stocks::$stockData[$report->STOCK_ID]['NAME'] }}</a></td>
                                <td>{{ Stocks::$stockData[$report->STOCK_ID]['TICKER'] }}</td>
                                <td style="color: green">${{ number_format($report->POOL / Stocks::getMaxShares($report->STOCK_ID), 2) }}</td>

                                @if (is_null($previous_report))
                                <td><b style="color: green">No Historical Data</b></td>
                                <td><b style="color: green">0.0%</b></td>
                                @else
                                <td><b style="color: {{ $price_change >= 0.0 ? 'green' : 'red' }}">${{ number_format($previous_report[0]->PRICE, 2)}}</b></td>
                                <td><b style="color: {{ $price_change >= 0.0 ? 'green' : 'red' }}">{{ ($price_change >= 0.0 ? '+' : '') . number_format($price_change, 2)}}%</b></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
<script type='text/javascript' src='{{URL::to('/')}}/assets/js/stock-flotgraph.js'></script>
@stop
