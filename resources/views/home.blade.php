@extends('layouts.app', ['menu' => 'home'])

@section('content')
    <h1 class="mb-3">Lőszernyilvántartás</h1>
    <div class="row">
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

    <h1 class="mt-3 mb-3">Lövészet</h1>
    @if(! empty($session))
        <a href="{{ route('shooting.index') }}" class="btn btn-success btn-lg">
            Folyamatban lévő lövészet megnyitása
        </a>
    @else
        <a href="{{ route('shooting.create') }}" class="btn btn-success btn-lg">
            Új lövészet indítása
        </a>
    @endif

@endsection
