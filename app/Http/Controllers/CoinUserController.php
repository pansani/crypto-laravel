<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCoin;

class CoinUserController  extends Controller
{
    public function userCoins(Request $request)
    {
        $userId = auth()->id();
        $coins = UserCoin::where('user_id', $userId)->with('coin')->get();

        foreach ($coins as $coinUser) {
            if ($coinUser->coin !== null) {
                if (!empty($coinUser->coin->chart_data)) {
                    $decodedData = json_decode($coinUser->coin->chart_data);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $coinUser->coin->chart_data = $decodedData;
                    } else {
                        echo 'Erro na decodificação JSON: ' . json_last_error_msg();
                    }
                } else {
                    echo 'chart_data está vazio ou nulo para coinUser com ID: ' . $coinUser->id;
                }
            } else {
                echo 'coin está nulo para coinUser com ID: ' . $coinUser->id;
            }
        }

        return response()->json($coins->pluck('coin'));
    }

    public function addCoin(Request $request)
    {
        $userId = auth()->id(); 
        $coinId = $request->input('coin_id');

        $existingCoinUser = UserCoin::where('user_id', $userId)->where('coin_id', $coinId)->first();
        if ($existingCoinUser) {
            return response()->json(['message' => 'Coin already added.'], 400);
        }

        UserCoin::create([
            'user_id' => $userId,
            'coin_id' => $coinId,
        ]);

        return response()->json(['message' => 'Coin added successfully.'], 200);
    }

    public function removeCoin($id)
    {
        $userId = auth()->id();
        $deleted = UserCoin::where('user_id', $userId)->where('coin_id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Coin removed successfully.'], 200);
        } else {
            return response()->json(['message' => 'Coin not found in user\'s list.'], 404);
        }
    }
}

