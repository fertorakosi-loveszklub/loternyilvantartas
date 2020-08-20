@extends('layouts.app', ['menu' => 'shooting'])

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h1 class="mb-3">Lövészet ({{ $session->title }})</h1>

            <div class="mb-3 d-flex">
                <a href="#" class="btn btn-success btn-lg" id="giveoutModalTrigger" data-toggle="modal" data-target="#giveoutModal">
                    Lőszer kiadása
                </a>

                <a href="#" class="btn btn-primary btn-lg ml-3" id="takebackModalTrigger" data-toggle="modal" data-target="#takebackModal">
                    Lőszer visszavételezése
                </a>

                <a href="#" class="btn btn-danger btn-lg ml-auto"  id="finishModalTrigger" data-toggle="modal" data-target="#finishModal">
                    Lövészet befejezése
                </a>
            </div>

            @if ($ammoSummary->isEmpty())
                <p class="alert alert-info">
                    Még nincs kiadott lőszer.
                </p>
            @else
                <div class="row">
                    @foreach($ammoSummary as $ammo)
                        <div class="col-6 col-lg-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4>{{ $ammo->ammo }}</h4>
                                    <span><strong>{{ $ammo->caliber->name }}</strong> kiadva</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h3>Összes kiadás / bevétel</h3>

            @if ($transactions->isEmpty())
                <p class="alert alert-info">
                    Még nem történt sem kiadás, sem visszavételezés.
                </p>
            @else
                <table class="table table-bordered">
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>
                                {{ $transaction->created_at->tz('Europe/Budapest')->format('H:i') }}
                            </td>
                            <td>
                                @if ($transaction->member)
                                    <span>{{ $transaction->member->name }} ({{ $transaction->member->birth_year }})</span>
                                @else
                                    <span class="text-muted">Közös lőszer</span>
                                @endif
                            </td>
                            <td>
                                @if ($transaction->quantity > 0)
                                    <span class="badge badge-warning">Kiadás</span>
                                @else
                                    <span class="badge badge-success">Visszavételezés</span>
                                @endif
                            </td>
                            <td>
                                {{ $transaction->caliber->name }}
                            </td>
                            <td class="text-right">
                                {{ abs($transaction->quantity) }} db lőszer
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>

    <div class="modal fade" id="giveoutModal" tabindex="-1" role="dialog" aria-labelledby="giveoutModalTrigger" aria-hidden="true">
        <form class="modal-dialog" role="document" method="POST" action="{{ route('shooting.giveout') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Lőszer kiadása</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="giveout_member">Tag</label>
                        <select name="member" id="giveout_member" class="form-control" data-target-class="giveout">
                            <option value="">- Közös lőszer -</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->name }} ({{ $member->birth_year }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="alert alert-info d-none" id="giveout-info">
                        A kivételezett lőszer a tag saját lőszereként kerül elmentésre.
                    </p>
                    @foreach($calibers as $caliber)
                        <div class="form-group">
                            <label for="quantity_{{ $caliber->id }}">{{ $caliber->name }}</label>
                            <input type="number"
                                   class="form-control giveout-ammo"
                                   min="0"
                                   step="1"
                                   name="quantity[{{ $caliber->id }}]"
                                   id="giveout_quantity_{{ $caliber->id }}"
                            >
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Mégsem</button>
                    <button type="submit" class="btn btn-success btn-lg">Kiadás</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="takebackModal" tabindex="-1" role="dialog" aria-labelledby="takebackModalTrigger" aria-hidden="true">
        <form class="modal-dialog" role="document" method="POST" action="{{ route('shooting.takeback') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Lőszer visszavételezése</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="takeback_member">Tag</label>
                        <select name="member" id="takeback_member" class="form-control" data-target-class="giveout">
                            <option value="">- Közös lőszer -</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->name }} ({{ $member->birth_year }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @foreach($calibers as $caliber)
                        <div class="form-group">
                            <label for="quantity_{{ $caliber->id }}">{{ $caliber->name }}</label>
                            <input type="number"
                                   class="form-control"
                                   min="0"
                                   step="1"
                                   name="quantity[{{ $caliber->id }}]"
                                   id="takeback_quantity_{{ $caliber->id }}"
                            >
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Mégsem</button>
                    <button type="submit" class="btn btn-primary btn-lg">Visszavételezés</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="finishModalTrigger" aria-hidden="true">
        <form class="modal-dialog modal-lg" role="document" method="POST" action="{{ route('shooting.finish') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Lövészet befejezése</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($ammoSummary->isEmpty())
                        <p class="alert alert-info">
                            A lövészet során egy lőszer sem fogyott.
                        </p>
                    @else
                        <p class="alert alert-info">
                            A lövészet során az alábbi lőszermennyiség fogyott. Ne felejtsd el rögzíteni a papír alapú lőszernaplóban.
                            <br>
                            <span class="font-weight-bold">A változások a lőszernyilvántartásban automatikusan rögzítésre kerülnek.</span>
                        </p>

                        <table class="table table-condensed">
                            <tbody>
                            @foreach($ammoSummary as $ammo)
                                <tr>
                                    <td style="width: 1%;white-space: nowrap">
                                        <strong>{{ $ammo->caliber->name }}</strong>
                                    </td>
                                    <td>{{ $ammo->ammo }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Mégsem</button>
                    <button type="submit" class="btn btn-primary btn-lg">Befejezés</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        window.member_ammo = {!! json_encode($memberAmmo) !!};
    </script>
@endsection
