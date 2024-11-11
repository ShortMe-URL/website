<?php

namespace App\Http\Controllers;

use App\Models\Clicks;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $linksCount = $user->links()->count();
        $clicksCount = $user->links()->withCount('clicks')->get()->sum('clicks_count');
        return view('dashboard.analytics', compact('linksCount', 'clicksCount'));
    }

    public function myurls(Request $request)
    {
        $user = Auth::user();


        $sortOption = $request->input('sort', 'newtoold');

        switch ($sortOption) {
            case 'oldtonew':
                $userLinks = $user->links()->orderBy('created_at', 'asc')->get();
                break;
            case 'newtoold':
            default:
                $userLinks = $user->links()->orderBy('created_at', 'desc')->get();
                break;
            case 'mostclicks':
                $userLinks = $user->links()->withCount('clicks')->orderBy('clicks_count', 'desc')->get();
                break;
        }

        return view('dashboard.myurls', compact('userLinks'));
    }

    public function mylinksdata()
    {
        $clicksData = Clicks::join('links', 'clicks.link_id', '=', 'links.id')
            ->where('links.user_id', Auth::id())
            ->selectRaw('MONTHNAME(clicks.created_at) as month, COUNT(*) as clicks_count')
            ->groupByRaw('MONTH(clicks.created_at), MONTHNAME(clicks.created_at)')
            ->orderByRaw('MONTH(clicks.created_at)')
            ->get()
            ->keyBy('month');

        $linksData = Link::where('user_id', Auth::id())
            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as links_count')
            ->groupByRaw('MONTH(created_at), MONTHNAME(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get()
            ->keyBy('month');

        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        return collect($allMonths)->map(function ($month) use ($clicksData, $linksData) {
            return [
                'month' => $month,
                'clicks_count' => $clicksData[$month]->clicks_count ?? 0,
                'links_count' => $linksData[$month]->links_count ?? 0,
            ];
        });
    }

    public function deleteURL(Request $request, $linkid)
    {
        $link = Auth::user()->links()->find($linkid);

        if (!$link) {
            return response()->json(['message' => 'Link not found or unauthorized.'], 404);
        }

        $link->delete();
        return response()->json(['message' => 'Link deleted successfully.'], 200);
    }
}
