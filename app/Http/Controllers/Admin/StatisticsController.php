<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{

    public function index(): \Illuminate\Contracts\View\View
    {
        $totalVisits = Visitor::select(DB::raw('DATE(created_at) as date'), 'ip_address')
            ->groupBy(DB::raw('DATE(created_at)'), 'ip_address')
            ->get()
            ->count();
        ;
        $totalProjects = Project::count();
        $totalComments = Comment::count();
        $totalMessages = Contact::count();

        $visitsByDate = Visitor::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(DISTINCT ip_address) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        $dates = $visitsByDate->pluck('date')->toArray();
        $counts = $visitsByDate->pluck('count')->toArray();
        
        $topProjects = Project::orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $subquery = Visitor::select(
            DB::raw('DATE(created_at) as visit_date'),
            'ip_address',
            'country'
        )
            ->whereNotNull('country')
            ->groupBy(DB::raw('DATE(created_at)'), 'ip_address', 'country');

        $visitorsByCountry = DB::table(DB::raw("({$subquery->toSql()}) as sub"))
            ->mergeBindings($subquery->getQuery()) // nécessaire pour passer les bindings
            ->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();


        $recentVisitors = Visitor::latest()
            ->take(10)
            ->get();
        
        $unreadMessages = Contact::where('is_read', false)->count();
        
        $pendingComments = Comment::where('is_approved', false)->count();
        
        return view('admin.statistics.index', compact(
            'totalVisits',
            'totalProjects',
            'totalComments',
            'totalMessages',
            'dates',
            'counts',
            'topProjects',
            'visitorsByCountry',
            'recentVisitors',
            'unreadMessages',
            'pendingComments'
        ));
    }
}
