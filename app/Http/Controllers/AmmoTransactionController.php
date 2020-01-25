<?php

namespace App\Http\Controllers;

use App\AmmoTransaction;
use App\Utilities\Ammo\AmmoCalculator;
use Illuminate\Http\Request;

class AmmoTransactionController extends Controller
{
    public function index(AmmoCalculator $calculator)
    {
        $transactions = AmmoTransaction::orderBy('created_at', 'desc')->paginate(50);

        return view('ammo_transactions', [
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
