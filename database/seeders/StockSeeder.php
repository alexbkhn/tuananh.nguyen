<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // Dữ liệu test: Mã VPB tăng giá 3 ngày liên tiếp
        $stockData = [
            // Mã VPB - tăng giá 3 ngày
            ['stock_code' => 'VPB', 'stock_date' => '2026-03-01', 'price_open' => 25000, 'price_high' => 25500, 'price_low' => 24900, 'price_close' => 25200, 'is_delete' => 0],
            ['stock_code' => 'VPB', 'stock_date' => '2026-03-02', 'price_open' => 25200, 'price_high' => 25800, 'price_low' => 25100, 'price_close' => 25600, 'is_delete' => 0],
            ['stock_code' => 'VPB', 'stock_date' => '2026-03-03', 'price_open' => 25600, 'price_high' => 26200, 'price_low' => 25500, 'price_close' => 26000, 'is_delete' => 0],
            ['stock_code' => 'VPB', 'stock_date' => '2026-03-04', 'price_open' => 26000, 'price_high' => 26100, 'price_low' => 25800, 'price_close' => 25900, 'is_delete' => 0],
            
            // Mã VCB
            ['stock_code' => 'VCB', 'stock_date' => '2026-03-01', 'price_open' => 80000, 'price_high' => 80500, 'price_low' => 79800, 'price_close' => 80200, 'is_delete' => 0],
            ['stock_code' => 'VCB', 'stock_date' => '2026-03-02', 'price_open' => 80200, 'price_high' => 80800, 'price_low' => 80000, 'price_close' => 80600, 'is_delete' => 0],
            ['stock_code' => 'VCB', 'stock_date' => '2026-03-03', 'price_open' => 80600, 'price_high' => 81200, 'price_low' => 80400, 'price_close' => 81000, 'is_delete' => 0],
            ['stock_code' => 'VCB', 'stock_date' => '2026-03-04', 'price_open' => 81000, 'price_high' => 81100, 'price_low' => 80800, 'price_close' => 80900, 'is_delete' => 0],
            
            // Mã ACB
            ['stock_code' => 'ACB', 'stock_date' => '2026-03-01', 'price_open' => 40000, 'price_high' => 40500, 'price_low' => 39500, 'price_close' => 40200, 'is_delete' => 0],
            ['stock_code' => 'ACB', 'stock_date' => '2026-03-02', 'price_open' => 40200, 'price_high' => 40800, 'price_low' => 40000, 'price_close' => 40500, 'is_delete' => 0],
            ['stock_code' => 'ACB', 'stock_date' => '2026-03-03', 'price_open' => 40500, 'price_high' => 41200, 'price_low' => 40300, 'price_close' => 41000, 'is_delete' => 0],
            ['stock_code' => 'ACB', 'stock_date' => '2026-03-04', 'price_open' => 41000, 'price_high' => 41100, 'price_low' => 40700, 'price_close' => 40800, 'is_delete' => 0],
        ];
        
        DB::table('stock')->insert($stockData);
    }
}
