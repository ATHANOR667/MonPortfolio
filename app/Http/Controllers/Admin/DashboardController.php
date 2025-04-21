<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


    public function index(): \Illuminate\Contracts\View\View
    {
        $stats = [
            'projects' => Project::count(),
            'comments' => Comment::count(),
            'messages' => Contact::count(),
            'visitors' => $count = Visitor::select(DB::raw('DATE(created_at) as date'), 'ip_address')
                ->groupBy(DB::raw('DATE(created_at)'), 'ip_address')
                ->get()
                ->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
