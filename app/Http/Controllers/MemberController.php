<?php

namespace App\Http\Controllers;

use App\Caliber;
use App\Member;
use App\Utilities\Ammo\PurchasedAmmoRepository;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request, PurchasedAmmoRepository $ammoRepository)
    {
        $members = Member::orderBy('updated_at', 'desc')
            ->with('purchasedAmmo')
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->get('q');
                $q->where('name', 'like', "%$term%");
            })
            ->get();

        $calibers = Caliber::all();

        return view('members', compact('members', 'calibers', 'ammoRepository'));
    }

    public function create(PurchasedAmmoRepository $ammoRepo)
    {
        $calibers = Caliber::all();

        return view('member', [
            'member' => new Member(),
            'ammoRepo' => $ammoRepo,
            'calibers' => $calibers,
        ]);
    }

    public function store(Request $request, PurchasedAmmoRepository $ammoRepo)
    {
        $request->validate([
            'name' => 'required',
            'birth_year' => 'required|integer|min:1900|max:2030'
        ]);

        $member = Member::create($request->all());
        $calibers = Caliber::all()->keyBy('id');

        foreach ($request->get('ammo', []) as $caliberId => $ammo) {
            $ammoRepo->setAmmo($member, $calibers[$caliberId], $ammo);
        }

        return redirect()->route('members.index');
    }

    public function edit(Member $member, PurchasedAmmoRepository $ammoRepo)
    {
        $calibers = Caliber::all();
        return view('member', compact('member', 'ammoRepo', 'calibers'));
    }

    public function update(Request $request, Member $member, PurchasedAmmoRepository $ammoRepo)
    {
        $request->validate([
            'name' => 'required',
            'birth_year' => 'required|integer|min:1900|max:2030'
        ]);

        $member->update($request->all());

        $calibers = Caliber::all()->keyBy('id');

        foreach ($request->get('ammo', []) as $caliberId => $ammo) {
            $ammoRepo->setAmmo($member, $calibers[$caliberId], $ammo);
        }

        return redirect()->route('members.index');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index');
    }
}
