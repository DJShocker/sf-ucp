@extends('layout/application')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 2em"></th>
                            <th style="padding-left: 1.5em; width: 0"><a href="highscores?page={{$gangs->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=tag">Clan</a></th>
                            <th><a href="/gangs/highscores?page={{$gangs->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=name">Name</a></th>
                            <th><a href="/gangs/highscores?page={{$gangs->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=score">Score</a></th>
                            <th><a href="/gangs/highscores?page={{$gangs->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=bank">Bank</a></th>
                            <th><a href="/gangs/highscores?page={{$gangs->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=kills">Kills</a></th>
                            <th><a href="/gangs/highscores?page={{$gangs->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=deaths">Deaths</a></th>
                            <th><a href="/gangs/highscores?page={{$gangs->getCurrentPage()}}&amp;sort={{$sort}}&amp;field=private">Private</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($gangs as $gang)
                                <tr>
                                    <td>
                                        <div style="position: absolute; display: block; background: #{{ $gang->color() }}; width: 1.5em; height: 1.5em; border: 1px solid #000;"> </div>
                                    </td>
                                    <td style="padding-left: 1.5em"><strong>{{{ $gang->CLAN_TAG }}}</strong></td>
                                    <td>
                                        <a href="{{ $gang->url() }}">
                                        @if ($gang->CLAN_TAG)
                                            <strong>{{{ $gang->NAME }}}</strong>
                                        @else
                                            {{{ $gang->NAME }}}
                                        @endif
                                        </a>
                                    </td>
                                    <td>{{ number_format($gang->SCORE) }}</td>
                                    <td>${{ number_format($gang->BANK) }}</td>
                                    <td>{{ number_format($gang->KILLS) }}</td>
                                    <td>{{ number_format($gang->DEATHS) }}</td>
                                    <td>{{ $gang->INVITE_ONLY ? "Yes" : "No" }}</td>
                                </tr>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div align="center">{{$gangs->appends(array('sort' => ($sort == "desc") ? "asc" : "desc", 'field' => strtolower($field) ))->links()}}</div>
        </div>
    </div>
</div>
@stop

@section('jscontent')
@stop
