<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $logs = ActivityLog::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($u) use ($search) {
                            $u->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->action, function ($query, $action) {
                $query->where('action', $action);
            })
            ->orderByDesc('id')
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('activity-logs.index', compact('logs', 'actions'));
    }
}
