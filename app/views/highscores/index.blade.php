@extends('layout/application')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=name">Name</a></th>
                            <th><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=score">Score</a></th>
                            <th><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=kills">Kills</a></th>
                            <th><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=deaths">Deaths</a></th>
                            <th class="hidden-xs"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=arrests">Arrests</a></th>
                            <th class="hidden-xs"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=robbery">Robberies</a></th>
                            <th class="hidden-xs hidden-sm"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=fires">Fires Extinguished</a></th>
                            <th class="hidden-xs hidden-sm"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=hits">Hits Completed</a></th>
                            <th class="hidden-xs hidden-sm"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=burglaries">Burglaries</a></th>
                            <th class="hidden-xs hidden-sm"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=blownjails">Blown Jails</a></th>
                            <th class="hidden-xs hidden-sm"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=blownbank">Blown Vault</a></th>
                            <th class="hidden-xs hidden-sm"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=vehjacked">Vehicles Jacked</a></th>
                            <th class="hidden-xs hidden-sm"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=meth">Meth Yielded</a></th>
                            <th class="hidden-xs hidden-sm"><a href="highscores?page={{$players->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=truck">Total Trucked Cargo</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($players as $user)
                                <tr>
                                    <td>{{ucfirst($user->NAME)}}</td>
                                    <td>{{$user->SCORE}}</td>
                                    <td>{{$user->KILLS}}</td>
                                    <td>{{$user->DEATHS}}</td>
                                    <td class="hidden-xs">{{$user->ARRESTS}}</td>
                                    <td class="hidden-xs">{{$user->ROBBERIES}}</td>
                                    <td class="hidden-xs hidden-sm">{{$user->FIRES}}</td>
                                    <td class="hidden-xs hidden-sm">{{$user->CONTRACTS}}</td>
                                    <td class="hidden-xs hidden-sm">{{$user->BURGLARIES}}</td>
                                    <td class="hidden-xs hidden-sm">{{$user->BLEW_JAILS}}</td>
                                    <td class="hidden-xs hidden-sm">{{$user->BLEW_VAULT}}</td>
                                    <td class="hidden-xs hidden-sm">{{$user->VEHICLES_JACKED}}</td>
                                    <td class="hidden-xs hidden-sm">{{$user->METH_YIELDED}}</td>
                                    <td class="hidden-xs hidden-sm">{{$user->TRUCKED}}</td>
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