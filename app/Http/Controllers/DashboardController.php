<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventGuest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeEvents = Event::where('status',1)->get()->count();
        $completeEvents = Event::where('status',2)->get()->count();
        $eventGuests = EventGuest::where('status',1)->get()->count();
        return view('dashboard',compact('activeEvents','completeEvents','eventGuests'));
    }
}
