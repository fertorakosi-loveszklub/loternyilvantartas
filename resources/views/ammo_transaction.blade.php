@extends('layouts.app', ['menu' => 'ammo'])

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Lőszerváltozás könyvelése</h1>

            <p class="alert alert-warning">
                <strong>Figyelem!</strong>
                Hibás könyvelés törlésésre vagy módosítására nincs lehetőség!
                Javítani kizárólag egy új könyveléssel lehetséges.
            </p>

            <div class="row">
                <div class="col col-lg-6">
                    <form action="{{ route('ammo.store') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="caliber_id">Kaliber</label>
                            <select name="caliber_id" id="caliber_id" class="form-control">
                                @foreach(\App\Caliber::orderBy('name')->get() as $caliber)
                                    <option value="{{ $caliber->id }}"
                                            @if ($caliber->id == old('caliber_id')) selected @endif
                                    >
                                        {{ $caliber->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Mennyiség</label>
                            <input type="number"
                                   class="form-control"
                                   min="-99999"
                                   max="99999"
                                   step="1"
                                   name="quantity"
                                   id="quantity"
                                   required
                                   value="{{ old('quantity', 0) }}"
                            >
                            <small class="form-text text-muted">
                                Írj pozitív számot, ha bevételt könyvelsz, negatívot (előjellel), ha kiadást.
                                Pl: 500, -200 stb.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="title">Jogcím</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="form-control"
                                   required
                                   value="{{ old('title') }}"
                            >
                            <small class="form-text text-muted">
                                Pl: edzés, verseny, bevétel, korrekció stb.
                                <br>
                            </small>
                        </div>

                        <button class="btn btn-success" type="submit">
                            Könyvelés
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
