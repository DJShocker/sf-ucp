@extends('layout/application')

@section('page-heading')
<h3 class="pull-right" style="padding-right: 48px">Your season 4 rank is <span class="text-success">{{RankS1::getIrresistibleRank($currentUser->RANK)}}</span>.</h3>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><a href="seasonal?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=name">Name</a></th>
                            <th><a href="seasonal?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=rank">Current Ranking</a></th>
                            <th><a href="seasonal?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=score">Score</a></th>
                            <th><a href="seasonal?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=kills">Kill Streak</a></th>
                            <th><a href="seasonal?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=arrest">Arrest Streak</a></th>
                            <th><a href="seasonal?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=robbery">Robbery Streak</a></th>
                            <th><a href="seasonal?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=rank_s1">Previous Ranking</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($players as $user)
                                <tr>
                                    <td>{{$user->NAME}}</td>
                                    <td>{{RankS1::getIrresistibleRank($user->RANK)}}</td>
                                    <td>{{$user->SCORE}}</td>
                                    <td>{{$user->KILL_STREAK or 0}}</td>
                                    <td>{{$user->ARREST_STREAK or 0}}</td>
                                    <td>{{$user->ROBBERY_STREAK or 0}}</td>
                                    <td>{{$user->OLD_RANK ? RankS1::getIrresistibleRank($user->OLD_RANK) : "<i>N/A</i>"}}</td>
                                </tr>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div align="center">{{$players->appends(array('sort' => ($sort == "desc") ? "asc" : "desc", 'field' => strtolower($field) ))->links()}}</div>
        </div>
    </div>
</div>
@stop

@section('jscontent')
@stop
