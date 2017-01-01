@extends('layout/application')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a class="info-tiles tiles-sky" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Registered Players</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-group"></i></div>
                    <div class="pull-right">{{Gliee\Irresistible\Utils::humanNumberFormat($registeredUsers)}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a class="info-tiles tiles-danger" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Banned Users</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-ban"></i></div>
                    <div class="pull-right">{{Gliee\Irresistible\Utils::humanNumberFormat($bannedUsers)}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a class="info-tiles tiles-green" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Printed Money</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-money"></i></div>
                    <div class="pull-right">${{Gliee\Irresistible\Utils::humanNumberFormat($totalCash)}}</div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6">
            <a class="info-tiles tiles-primary" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Tax Rate</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-dollar"></i></div>
                    <div class="pull-right">{{$taxRate}}</div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6">
            <a class="info-tiles tiles-inverse" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Server Vehicles</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-truck"></i></div>
                    <div class="pull-right">{{$totalVehicles}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6">
            <a class="info-tiles tiles-indigo" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Server Houses</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-home"></i></div>
                    <div class="pull-right">{{$totalHouses}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6">
            <a class="info-tiles tiles-brown" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Server Gates</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-sign-in"></i></div>
                    <div class="pull-right">{{$totalGates}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6">
            <a class="info-tiles tiles-magenta" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Server Apartments</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-suitcase"></i></div>
                    <div class="pull-right">{{$totalApartments}}</div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">V.I.P Player Notes</div>
                <div class="panel-body panel-stats" style="height:400px; overflow:auto;">
                @if(!count($playerNotes))
                    <div align="center" style="padding-top:125px"><h1>There aren't any V.I.P player notes currently.</h1></div>
                @else
                    <table class="table table-stats table-hover">
                        <thead>
                            <tr>
                                <td><strong>ID</strong></td>
                                <td><strong>Date</strong></td>
                                <td><strong>User</strong></td>
                                <td><strong>Added By</strong></td>
                                <td><strong>Note</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($playerNotes as $key)
                            <tr>
                                <td>{{{$key->ID}}}</td>
                                <td>{{{$key->TIME}}}</td>
                                @if ($key->user)
                                    <td>{{{$key->user->NAME}}}</td>
                                @else
                                    <td style="color: red"><strong>User Does Not Exist</strong></td>
                                @endif

                                @if ($key->author)
                                    <td>{{{$key->author->NAME}}}</td>
                                @else
                                    <td style="color: red"><strong>Author Does Not Exist</strong></td>
                                @endif
                                <td>{{{preg_replace('/(?i){[a-f0-9]+}/', '', $key->NOTE)}}}</td>
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
