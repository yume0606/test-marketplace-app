<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('sell.sell', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExhibitionRequest $request)
    {
        $image = $request->file('image');
        $imagePath = $image->storeAs(
            'items',
            uniqid() . '.' . $image->getClientOriginalExtension(),
            'public'
        );

        $item = Item::create([
            'user_id' => auth()->id(),
            'condition' => $request->condition,
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            //'カラム名'=>$requestで送られた名前
        ]);
        $item->categories()->attach($request->categories);

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
