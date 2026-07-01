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
        $keyword = $request->get('keyword');

        if ($request->get('tab') === 'mylist') {
            // 未認証の場合は空を返す
            if (!auth()->check()) {
                $items = collect();
            } else {
                $items = auth()->user()->likes()
                    ->with('item.order')
                    ->whereHas('item', function ($query) use ($keyword) {
                        $query->when($keyword, function ($q) use ($keyword) {
                            $q->where('name', 'like', "%{$keyword}%");
                        });
                    })
                    ->get()
                    ->pluck('item');
            }
        } else {
            $items = Item::with('order')
                ->when(auth()->check(), function ($query) {
                    $query->where('user_id', '!=', auth()->id());
                })
                ->when($keyword, function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->latest()
                ->get();
        }

        return view('top.index', compact('items', 'keyword'));
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
