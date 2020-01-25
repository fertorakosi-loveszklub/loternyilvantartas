@extends('layouts.app', ['menu' => 'ammo'])

@section('content')
    <div class="row mb-3">
        @foreach($ammos as $ammo)
            <div class="col-2 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h1>{{ $ammo->ammo }}</h1>
                        <span>{{ $ammo->caliber->name }} készleten</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('ammo.create') }}" class="btn btn-success">
                Lőszerváltozás könyvelése
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-bordered mb-3">
                <thead class="thead-dark">
                <tr>
                    <th>Dátum</th>
                    <th>Kaliber</th>
                    <th>Változás</th>
                    <th>Jogcím</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('Y. m. d.') }}</td>
                        <td>{{ $transaction->caliber->name }}</td>
                        <td>
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
                        <td>{{ $transaction->title }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $transactions->links() }}
        </div>
    </div>
@endsection
