<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    /**
     * Display the security options page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $admin = User::where('email', null);
            $default = $admin->exists() ? true : false;
        } catch (\Exception $e) {
            $default = false;
        }

        $user = Auth::guard('admin')->user();

        return view('admin.security.index', [
            'default' => $default,
            'user' => $user
        ]);
    }
}
