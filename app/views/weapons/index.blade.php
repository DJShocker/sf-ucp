@extends('layout/application')

@section('page-heading')
<h3 class="pull-right" style="padding-right: 48px">Your favourite weapon is <span class="text-primary">{{ isset($weaponData[0]) ? $weaponData[0]->name() : 'N/A' }}</span>.</h3>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Weapon</th>
                            <th>Total kills</th>
                            <th>#1</th>
                            <th>#2</th>
                            <th>#3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($weaponData as $weapon)
                            <tr>
                                <td><img src="{{ $weapon->image() }}" alt="{{ $weapon->name() }}" aria-label="{{ $weapon->name() }}" height="48px"></td>
                                <td class="text-primary"><strong>{{ number_format($weapon->KILLS) }}</strong></td>

                                @foreach ($weapon->tops as $top)
                                    <td>{{ $top->KILLS }} ({{ $top->user->NAME }})</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <strong>Kill somebody in-game to reveal some weapon statistics!</strong>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <span class="text-warning">Weapons without kills:</span> {{ $incompleteWeapons }}
        </div>
    </div>
</div>
@stop