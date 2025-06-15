<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified'])->only(['create','store']);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'title'   => $data['title'],
            'body'    => $data['body'],
        ]);

        return redirect()->route('archives')
                         ->with('success','Post published!');
    }
}
