<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('profile.mypage-index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile.mypage-edit', compact('user'));
    }

    public function address_edit(Item $item)
    {
        $user = auth()->user();
        return view('profile.address', compact('user', 'item'));
    }

    public function address_update(Request $request, Item $item)
    {
        $user = auth()->user();

        $request->validate([
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect()->route('items.purchase', $item->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // 画像が送られてきた場合だけ保存処理を行う
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_image', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect()->route('mypage');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
