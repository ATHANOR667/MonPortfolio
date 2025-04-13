<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Visitor;

class DashboardController extends Controller
{


    public function index(): \Illuminate\Contracts\View\View
    {
        $stats = [
            'projects' => Project::count(),
            'comments' => Comment::count(),
            'messages' => Contact::count(),
            'visitors' => Visitor::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
