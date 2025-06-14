<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tournament;

class CommentController extends Controller
{
    public function __construct()
    {
        // Only verified users can comment
        $this->middleware(['auth','verified']);
    }

    /**
     * Store a new comment for a given tournament.
     */
    public function store(Request $request, Tournament $tournament)
    {
        $data = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $tournament->comments()->create([
            'user_id' => Auth::id(),
            'body'    => $data['body'],
        ]);

        return back()->with('success', 'Comment posted!');
    }
}
