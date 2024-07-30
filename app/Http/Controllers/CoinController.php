<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coin;

class CoinController extends Controller
{
    public function allCoins()
    {
        $coins = Coin::all();

        foreach ($coins as $coin) {
            $coin->chart_data = json_decode($coin->chart_data);
        }

        return response()->json($coins);
    }
}

