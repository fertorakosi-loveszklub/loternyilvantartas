@extends('layouts.app', ['menu' => 'members'])

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST"
                  @if ($member->exists)
                  action="{{ route('members.update', ['member' => $member]) }}"
                  @else
                  action="{{ route('members.store') }}"
                @endif
            >
                @if ($member->exists)
                    {{ method_field('PUT') }}
                @endif

                {{ csrf_field() }}

                <h1 class="mb-3">Tag</h1>
                <div class="row">
                    <div class="col col-lg-6">
                        <div class="form-group">
                            <label for="name">Tag neve</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder=""
                                   required
                                   autofocus
                                   value="{{ $member->name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-lg-6">
                        <div class="form-group">
                            <label for="name">Szül. év</label>
                            <input type="number"
                                   min="1900"
                                   max="2030"
                                   id="birth_year"
                                   name="birth_year"
                                   class="form-control"
                                   placeholder=""
                                   required
                                   value="{{ $member->birth_year }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Mentés</button>
            </form>
        </div>
    </div>
@endsection
