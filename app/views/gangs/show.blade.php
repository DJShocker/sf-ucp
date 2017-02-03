@extends('layout/application')

@section('page-heading')
    <div class="pull-right hidden-xs" style="margin-right: 3em; margin-top: 1em">
        <div style="display: block; background: #{{ $gang->color() }}; width: 3em; height: 3em; border: 1px solid #000;"> </div>
    </div>
@stop

@section('content')

<div class="container">
    <div class="row">
        <!-- stats -->
        <div class="col-md-12">
            <div class="panel panel-brown">
                <div class="panel-heading">
                    <h4><i class="fa fa-gamepad"></i> Game Statistics</h4>
                </div>
                <div class="panel-body panel-stats">

                    <table class="table table-stats table-hover">
                        <tbody>
                            <tr>
                                <td>Official Clan</td>
                                <td>
                                    @if ($gang->CLAN_TAG)
                                        <span class="label label-danger">{{{ $gang->CLAN_TAG }}}</span>
                                    @else
                                        <strong>No</strong>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Score</td>
                                <td>{{ number_format($gang->SCORE) }}</td>
                            </tr>
                            <tr>
                                <td>Bank</td>
                                <td>{{ number_format($gang->BANK) }}</td>
                            </tr>
                            <tr>
                                <td>Kills</td>
                                <td>{{ number_format($gang->KILLS) }}</td>
                            </tr>
                            <tr>
                                <td>Deaths</td>
                                <td>{{ number_format($gang->DEATHS) }}</td>
                            </tr>
                            <tr>
                                <td>Private <small>(joinable through leaders only)</small></td>
                                <td>{{ $gang->INVITE_ONLY ? "Yes" : "No" }}</td>
                            </tr>
                            <tr>
                                <td>Average Activity</td>
                                <td>{{Gliee\Irresistible\Utils::secondstohuman($averageActivity)}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- members -->
        <div class="col-md-12">
            <div class="panel panel-midnightblue">
                <div class="panel-heading">
                    <h4><i class="fa fa-group"></i> Members</h4>
                </div>
                <div class="panel-body panel-stats" style="max-height: 400px; overflow:auto;">

                    <table class="table table-stats table-hover"
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Score</th>
                                <th>Last Active</th>
                                <th>Weekly Time</th>
                                <th>Status</th>
                            @if ($isClanLeader)
                                <th class="text-danger">Manage User</th>
                            @endif
                            </tr>

                        </thead>
                        <tbody>
                            @forelse ($members as $member)
                            <tr>
                                <td>
                                    @if ($gang->is_leader($member))
                                        <strong>{{{ $member->NAME }}}</strong>

                                        @if ($gang->LEADER == $member->ID)
                                            <span class="label label-primary pull-right">Leader</span>
                                        @else
                                            <span class="label pull-right" style="background: gray">Coleader</span>
                                        @endif
                                    @else
                                        {{{ $member->NAME }}}
                                    @endif
                                </td>
                                <td>{{ number_format($member->SCORE) }}</td>
                                <td>{{ Carbon\Carbon::createFromTimeStamp($member->LASTLOGGED)->diffForHumans() }}</td>
                                <td>{{ Gliee\Irresistible\Utils::secondstohuman($member->UPTIME - $member->WEEKEND_UPTIME) }}</td>
                                <td>
                                    @if ($member->ONLINE)
                                        <span style="color: green"><strong>ONLINE</strong></span>
                                    @else
                                        <span style="color: red">Offline</span>
                                    @endif
                                </td>
                            @if ($isClanLeader)
                                <td><a href="#" data-url="{{ route('gangs.kick', [$gang->ID, $member->ID]) }}" class="kickPlayer">Kick From Clan</a></td>
                            @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Nothing to show</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section ('jscontent')
<script type="text/javascript">
    $('.kickPlayer').click(function (e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        row.fadeOut(1000);

        //if (window.confirm("Are you sure that you want to remove this member?")) {
            var like = $.ajax($(this).data('url')).done(function()
            {
                var data = $.parseJSON(like['responseText']);

                if (data.error) {
                    row.fadeIn();
                    alert(data.error);
                }
            });
        //}
    });
</script>
@stop
