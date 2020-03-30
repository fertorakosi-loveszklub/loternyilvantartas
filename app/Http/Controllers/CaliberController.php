<?php

namespace App\Http\Controllers;

use App\Caliber;
use Illuminate\Http\Request;

class CaliberController extends Controller
{
    public function index()
    {
        $calibers = Caliber::orderBy('name')->get();
        return view('calibers', compact('calibers'));
    }

    public function create()
    {
        return view('caliber', [
            'caliber' => new Caliber()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:calibers,name'
        ]);

        Caliber::create($request->all());

        return redirect()->route('calibers.index');
    }

    public function edit(Caliber $caliber)
    {
        return view('caliber', [
            'caliber' => $caliber
        ]);
    }

    public function update(Request $request, Caliber $caliber)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $caliber->update($request->all());

        return redirect()->route('calibers.index');
    }

    public function destroy(Caliber $caliber)
    {
        $caliber->delete();
        return redirect()->route('calibers.index');
    }
}
