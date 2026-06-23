<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Models\Item;
use Illuminate\Http\Request;

class LikeController extends Controller
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
    public function create(Item $item)
    {
        $user = auth()->user();

        $like = $item->like()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $item->like()->create(['user_id' => $user->id]);
            $liked = true;
        }
        return response()->json([
            'liked' => $liked,
            'count' => $item->like()->count(),
        ]);

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
    public function show(like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(like $like)
    {
        //
    }
}
