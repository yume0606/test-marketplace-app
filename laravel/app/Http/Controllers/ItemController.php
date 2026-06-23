<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->get('tab') === 'mylist' && auth()->check()) {
            // マイリスト(いいねした商品)を表示
            $items = auth()->user()->likes()->with('item.order')->get()->pluck('item');
        } else {
            // おすすめ(全商品、自分の出品は除外)
            $items = Item::with('order')
                ->when(auth()->check(), function ($query) {
                    $query->where('user_id', '!=', auth()->id());
                })
                ->latest()
                ->get();
        }
        return view('top.index', compact('items'));
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
    public function show(Item $item)
    {
        return view('top.detail', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
