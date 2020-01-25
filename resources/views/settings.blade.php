@extends('layouts.app', ['menu' => 'settings'])

@section('content')
    <h1 class="mb-3">Beállítások</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('settings.backup') }}" method="POST">
                {{ csrf_field() }}
                <p>
                    Az adatvesztés elkerülése érdekében célszerű időnként biztonsági mentést
                    készíteni egy másik adathordozóra (USB drive stb.).
                </p>

                <button type="submit" class="btn btn-primary">
                    Biztonsági mentés készítése
                </button>
            </form>
        </div>
    </div>
@endsection
