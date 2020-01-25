@extends('layouts.app', ['menu' => 'shooting'])

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Lövészet indítása</h1>

            <div class="row">
                <div class="col col-lg-6">
                    <form action="{{ route('shooting.store') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="title">Megnevezés</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="form-control"
                                   required
                                   value="{{ old('title', 'Edzés') }}"
                            >
                            <small class="form-text text-muted">
                                Pl: edzés, verseny stb.
                                <br>
                            </small>
                        </div>

                        <button class="btn btn-success" type="submit">
                            Lövészet indítása
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
