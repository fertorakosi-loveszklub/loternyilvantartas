<?php

namespace App\Http\Controllers;

use App\AmmoTransaction;
use App\Caliber;
use App\Utilities\Ammo\AmmoCalculator;
use Illuminate\Http\Request;

class AmmoTransactionController extends Controller
{
    public function index(Request $request, AmmoCalculator $calculator)
    {
        $calibers = Caliber::orderBy('name')->get();

        $transactions = AmmoTransaction::orderBy('created_at', 'desc')
            ->when($request->filled('caliber_id'), function ($q) use ($request) {
                $q->where('caliber_id', $request->get('caliber_id'));
            })
            ->paginate(50);

        return view('ammo_transactions', [
            'calibers' => $calibers,
            'transactions' => $transactions,
            'ammos' => $calculator->getAmmoForEachCaliber(),
        ]);
    }

    public function create()
    {
        return view('ammo_transaction');
    }

    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:-99999|max:99999',
            'title' => 'required',
        ]);

        AmmoTransaction::create($request->all());
        return redirect()->route('ammo.index');
    }
}
