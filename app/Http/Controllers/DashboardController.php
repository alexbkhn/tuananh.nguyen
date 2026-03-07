<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Tiền nạp từ bảng nav_savings
            $r_in1 = DB::table('nav_savings')
                ->where('is_delete', 0)
                ->sum('money_deposit');
            $r_in1 = $r_in1 ?? 0;
            
            // Tiền rút từ bảng nav_savings
            $r_out1 = DB::table('nav_savings')
                ->where('is_delete', 0)
                ->sum('money_saving');
            $r_out1 = $r_out1 ?? 0;
            
            // Tổng tiền mua cổ phiếu
            $tong_tien_mua = DB::table('stock_history')
                ->where('transaction_type', 'Mua')
                ->where('is_delete', 0)
                ->sum('total_money');
            $tong_tien_mua = $tong_tien_mua ?? 0;
            
            // Tổng tiền bán cổ phiếu
            $tong_tien_ban = DB::table('stock_history')
                ->where('transaction_type', 'Bán')
                ->where('is_delete', 0)
                ->sum('total_money');
            $tong_tien_ban = $tong_tien_ban ?? 0;
            
            // Tổng phí giao dịch
            $tong_phí = DB::table('stock_history')
                ->where('is_delete', 0)
                ->sum('total_fee');
            $tong_phí = $tong_phí ?? 0;
            
            // Tiền còn lại trong tiết kiệm
            $tien_con_lai = max(0, $r_in1 - $r_out1);
            
            // Giá trị danh mục cổ phiếu
            $gia_tri_dau_tu = max(0, $tong_tien_mua - $tong_tien_ban);
            
            $data = [
                'r_in1' => is_numeric($r_in1) ? $r_in1 : 0,
                'r_out1' => is_numeric($r_out1) ? $r_out1 : 0,
                'tien_con_lai' => is_numeric($tien_con_lai) ? $tien_con_lai : 0,
                'tong_tien_mua' => is_numeric($tong_tien_mua) ? $tong_tien_mua : 0,
                'tong_tien_ban' => is_numeric($tong_tien_ban) ? $tong_tien_ban : 0,
                'tong_phí' => is_numeric($tong_phí) ? $tong_phí : 0,
                'gia_tri_dau_tu' => is_numeric($gia_tri_dau_tu) ? $gia_tri_dau_tu : 0,
            ];
            
            return view('admin.dashboard', $data);
        } catch (\Exception $e) {
            return view('admin.dashboard', [
                'error' => 'Database error: ' . $e->getMessage(),
                'r_in1' => 0,
                'r_out1' => 0,
                'tien_con_lai' => 0,
                'tong_tien_mua' => 0,
                'tong_tien_ban' => 0,
                'tong_phí' => 0,
                'gia_tri_dau_tu' => 0,
            ]);
        }
    }
}
