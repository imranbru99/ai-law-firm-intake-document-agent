<?php

namespace App\Http\Controllers;

use App\Models\Matter;
use App\Models\PortalMessage;
use App\Services\ModuleManager;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function index(Request $request, ModuleManager $modules): View
    {
        abort_unless($modules->enabled('client_portal'), 404);

        $user = $request->user();
        $matters = Matter::query()
            ->whereHas('client', fn ($q) => $q->where('portal_user_id', $user?->id))
            ->with('documents')
            ->latest()
            ->get();

        $messages = PortalMessage::query()
            ->whereHas('client', fn ($q) => $q->where('portal_user_id', $user?->id))
            ->latest()
            ->limit(20)
            ->get();

        return view('portal.index', compact('matters', 'messages'));
    }
}