@extends('layouts.app', ['menu' => 'members'])

@section('content')
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('members.create') }}" class="btn btn-lg btn-success">
                Új tag
            </a>
        </div>
        <div class="col-4 ml-auto">
            <form method="GET">
                <input class="form-control form-control-lg" type="text" name="q" value="{{ request('q') }}" placeholder="Keresés">
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>Név</th>
            <th>Szül. év</th>
            <th>Lőszer</th>
            <th class="text-right"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->birth_year }}</td>
                <td>
                    @foreach($calibers as $caliber)
                        @if (($ammo = $ammoRepository->getAmmo($member, $caliber)) > 0)
                            <p class="mb-0">
                                <small class="text-muted">
                                    <strong>{{ $caliber->name }}:</strong> {{ $ammo }}
                                </small>
                            </p>
                        @endif
                    @endforeach
                </td>
                <td class="text-right">
                    <a href="{{ route('members.edit', ['member'=> $member]) }}" class="btn btn-primary">
                        Szerkesztés
                    </a>

                    <form action="{{ route('members.destroy', ['member'=> $member]) }}" method="POST" class="d-inline-block">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}

                        <button class="btn btn-danger" type="submit">
                            Törlés
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
