<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;

class BuyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function buy_index(Item $item)
    {
        return view('buy.buy', compact('item'));
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
    public function store(PurchaseRequest $request, Item $item)
    {
        $user = auth()->user();

        if (!$user->postal_code || !$user->address) {
            return redirect()
                ->route('items.purchase', $item->id)
                ->withErrors(['address' => '配送先を入力してください'])
                ->withInput();
        }
        Order::create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
            'purchased_at' => now(),
        ]);
        return redirect()->route('items.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
