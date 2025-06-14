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
                return view('dashboard');       // dashboard.blade.php
            case 'verified':
                return view('admin.index');     // admin/index.blade.php
            default:
                abort(403);                     // forbidden
        }
    }

    public function homepage()
    {
        return view('home.homepage');
    }
}
