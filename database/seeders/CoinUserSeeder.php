<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoinUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all coin IDs
        $coinIds = DB::table('coins')->pluck('id');

        // Associate all coins with the user having id = 1
        foreach ($coinIds as $coinId) {
            DB::table('coin_user')->insert([
                'user_id' => 1,
                'coin_id' => $coinId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
