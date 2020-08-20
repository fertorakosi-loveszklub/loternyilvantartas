<?php

namespace App\Http\Controllers;

use App\Caliber;
use App\Member;
use App\Utilities\Ammo\PurchasedAmmoRepository;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchasedAmmoRepository $ammoRepository)
    {
        $members = Member::orderBy('updated_at', 'desc')
            ->with('purchasedAmmo')
            ->get();

        $calibers = Caliber::all();

        return view('members', compact('members', 'calibers', 'ammoRepository'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PurchasedAmmoRepository $ammoRepo)
    {
        $calibers = Caliber::all();

        return view('member', [
            'member' => new Member(),
            'ammoRepo' => $ammoRepo,
            'calibers' => $calibers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member, PurchasedAmmoRepository $ammoRepo)
    {
        $calibers = Caliber::all();
        return view('member', compact('member', 'ammoRepo', 'calibers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index');
    }
}
