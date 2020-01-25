@extends('layouts.app', ['menu' => 'calibers'])

@section('content')
    <div class="mb-3">
        <a href="{{ route('calibers.create') }}" class="btn btn-success">
            Új kaliber
        </a>
    </div>

    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>Kaliber</th>
            <th class="text-right"></th>
        </tr>
        </thead>
        @foreach($calibers as $caliber)
            <tr>
                <td>{{ $caliber->name }}</td>
                <td class="text-right">
                    <a href="{{ route('calibers.edit', ['caliber'=> $caliber]) }}" class="btn btn-primary">
                        Szerkesztés
                    </a>

                    <form action="{{ route('calibers.destroy', ['caliber' => $caliber]) }}" method="POST" class="d-inline-block">
                        {{ method_field('DELETE') }}

                        <button class="btn btn-danger" type="submit">
                            Törlés
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
