@extends('layouts.app', ['menu' => 'calibers'])

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST"
                  @if ($caliber->exists)
                    action="{{ route('calibers.update', ['caliber' => $caliber]) }}"
                  @else
                    action="{{ route('calibers.store') }}"
                  @endif
            >
                @if ($caliber->exists)
                    {{ method_field('PUT') }}
                @endif

                {{ csrf_field() }}

                <h1 class="mb-3">Kaliber</h1>
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label for="name">Kaliber megnevezése</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       placeholder=".22LR, .45 ACP stb."
                                       required
                                       value="{{ $caliber->name }}">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Mentés</button>
            </form>
        </div>
    </div>
@endsection
