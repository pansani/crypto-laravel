<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coins = [
            [
                'rank' => 1,
                'name' => 'Bitcoin',
                'symbol' => 'BTC',
                'icon' => 'https://cryptologos.cc/logos/bitcoin-btc-logo.png',
                'price' => '65,550.90',
                'change1h' => -0.2,
                'change24h' => -0.4,
                'change7d' => 1.6,
                'market_cap' => '1,288,680,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [62, 64, 63, 65, 67, 66, 65],
                    'color' => "rgba(75,192,192,1)",
                    'backgroundColor' => "rgba(75,192,192,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 2,
                'name' => 'Ethereum',
                'symbol' => 'ETH',
                'icon' => 'https://cryptologos.cc/logos/ethereum-eth-logo.png',
                'price' => '4,320.45',
                'change1h' => 0.1,
                'change24h' => -0.3,
                'change7d' => 2.3,
                'market_cap' => '498,230,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [42, 44, 43, 45, 47, 46, 45],
                    'color' => "rgba(255,99,132,1)",
                    'backgroundColor' => "rgba(255,99,132,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 3,
                'name' => 'Ripple',
                'symbol' => 'XRP',
                'icon' => 'https://cryptologos.cc/logos/xrp-xrp-logo.png',
                'price' => '1.22',
                'change1h' => -0.1,
                'change24h' => 0.5,
                'change7d' => -0.3,
                'market_cap' => '58,230,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [0.92, 0.94, 0.93, 0.95, 0.97, 0.96, 0.95],
                    'color' => "rgba(54,162,235,1)",
                    'backgroundColor' => "rgba(54,162,235,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 4,
                'name' => 'Litecoin',
                'symbol' => 'LTC',
                'icon' => 'https://cryptologos.cc/logos/litecoin-ltc-logo.png',
                'price' => '215.60',
                'change1h' => 0.4,
                'change24h' => -0.2,
                'change7d' => 1.0,
                'market_cap' => '14,230,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [212, 214, 213, 215, 217, 216, 215],
                    'color' => "rgba(153,102,255,1)",
                    'backgroundColor' => "rgba(153,102,255,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 5,
                'name' => 'Cardano',
                'symbol' => 'ADA',
                'icon' => 'https://cryptologos.cc/logos/cardano-ada-logo.png',
                'price' => '2.30',
                'change1h' => 0.5,
                'change24h' => -0.1,
                'change7d' => 3.2,
                'market_cap' => '73,130,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [2.1, 2.15, 2.18, 2.22, 2.28, 2.25, 2.30],
                    'color' => "rgba(75,192,192,1)",
                    'backgroundColor' => "rgba(75,192,192,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 6,
                'name' => 'Polkadot',
                'symbol' => 'DOT',
                'icon' => 'https://cryptologos.cc/logos/polkadot-new-dot-logo.png',
                'price' => '39.50',
                'change1h' => -0.3,
                'change24h' => 0.2,
                'change7d' => 4.1,
                'market_cap' => '38,230,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [37.5, 38.0, 38.2, 38.6, 39.0, 39.2, 39.5],
                    'color' => "rgba(54,162,235,1)",
                    'backgroundColor' => "rgba(54,162,235,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 7,
                'name' => 'Dogecoin',
                'symbol' => 'DOGE',
                'icon' => 'https://cryptologos.cc/logos/dogecoin-doge-logo.png',
                'price' => '0.25',
                'change1h' => 0.1,
                'change24h' => -0.2,
                'change7d' => 1.5,
                'market_cap' => '32,230,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [0.22, 0.23, 0.24, 0.24, 0.25, 0.24, 0.25],
                    'color' => "rgba(255,159,64,1)",
                    'backgroundColor' => "rgba(255,159,64,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 8,
                'name' => 'Binance Coin',
                'symbol' => 'BNB',
                'icon' => 'https://cryptologos.cc/logos/binance-coin-bnb-logo.png',
                'price' => '520.45',
                'change1h' => -0.1,
                'change24h' => 0.3,
                'change7d' => 2.6,
                'market_cap' => '78,230,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [505, 510, 512, 515, 518, 520, 520.45],
                    'color' => "rgba(255,206,86,1)",
                    'backgroundColor' => "rgba(255,206,86,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 9,
                'name' => 'Solana',
                'symbol' => 'SOL',
                'icon' => 'https://cryptologos.cc/logos/solana-sol-logo.png',
                'price' => '190.23',
                'change1h' => 0.2,
                'change24h' => -0.4,
                'change7d' => 3.4,
                'market_cap' => '57,230,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [180, 182, 184, 185, 188, 189, 190.23],
                    'color' => "rgba(153,102,255,1)",
                    'backgroundColor' => "rgba(153,102,255,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 10,
                'name' => 'Chainlink',
                'symbol' => 'LINK',
                'icon' => 'https://cryptologos.cc/logos/chainlink-link-logo.png',
                'price' => '29.50',
                'change1h' => -0.2,
                'change24h' => 0.4,
                'change7d' => 1.9,
                'market_cap' => '29,230,715,467',
                'chart_data' => json_encode([
                    'labels' => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    'data' => [28, 28.5, 29, 29.3, 29.4, 29.5, 29.5],
                    'color' => "rgba(75,192,192,1)",
                    'backgroundColor' => "rgba(75,192,192,0.2)",
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('coins')->insert($coins);
    }
}

