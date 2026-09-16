<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;

class LandingController extends Controller
{
    public function index()
    {
        $featuredEvents = Event::where('status', 'active')
            ->with(['seller.sellerProfile', 'categories'])
            ->latest()
            ->take(6)
            ->get();

        return Inertia::render('Landing', [
            'featuredEvents' => $featuredEvents,
        ]);
    }
}
