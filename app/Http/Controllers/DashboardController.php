<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Coin;

class DashboardController extends Controller
{
    public function index(Request $request)
    { 
        $user = $request->user();
        $coins = $user->coins()->get();

        return Inertia::render('Dashboard', [
            'coins' => $coins,
            'user' => $user,
        ]);
    }
}

