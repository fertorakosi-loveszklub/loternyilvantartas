@extends('layouts.app', ['menu' => 'shooting'])

@section('content')
    <div class="mb-3">
        <a href="{{ route('shooting.create') }}" class="btn btn-lg btn-success">
            Lövészet indítása
        </a>
    </div>

    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>Dátum</th>
            <th>Megnevezés</th>
            <th>Ellőtt lőszerek</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sessions as $shooting)
            <tr>
                <td>{{ $shooting->created_at->format('Y. m. d.') }}</td>
                <td>{{ $shooting->title }}</td>
                <td>
                    @if ($shooting->ammoSummary->isEmpty())
                        <small class="text-muted">Nem fogyott lőszer</small>
                    @else
                        @foreach($shooting->ammoSummary as $ammo)
                            <span class="badge badge-secondary">
                                {{ $ammo->ammo }} db {{ $ammo->caliber->name }}
                            </span>
                        @endforeach
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $sessions->links() }}
    </div>
@endsection
