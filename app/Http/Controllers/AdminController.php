<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }
        $role = Auth::user()->role;

        switch ($role) {
            case 'viewer':
                return view('dashboard');
            case 'verified':
                return view('admin.index');
            default:
                abort(403);
        }
    }

    public function homepage()
    {
        return view('home.homepage');
    }
}
