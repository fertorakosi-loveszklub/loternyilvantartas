@extends('layouts.app', ['menu' => 'ammo'])

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <a href="{{ route('ammo.create') }}" class="btn btn-lg btn-success">
                Lőszerváltozás könyvelése
            </a>

            <table class="table table-bordered mt-3 mb-3">
                <thead class="thead-dark">
                <tr>
                    <th>Dátum</th>
                    <th>Kaliber</th>
                    <th>Jogcím</th>
                    <th class="text-right">Változás</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('Y. m. d.') }}</td>
                        <td>{{ $transaction->caliber->name }}</td>
                        <td>{{ $transaction->title }}</td>
                        <td class="text-right">
                            <span
                                @if ($transaction->quantity > 0)
                                class="badge badge-success"
                                @else
                                class="badge badge-danger"
                                @endif
                            >
                                {{ $transaction->quantity }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $transactions->links() }}

        </div>
        <div class="col-lg-3">
            @foreach($ammos as $ammo)
                <div class="card mb-3">
                    <div class="card-body">
                        <h1>{{ $ammo->ammo }}</h1>
                        <span>{{ $ammo->caliber->name }} készleten</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
