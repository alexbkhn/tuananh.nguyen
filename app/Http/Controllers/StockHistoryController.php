<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\StockHistoryModel;
use App\Models\StockCompanyModel;
use Auth;
use Illuminate\Support\Facades\DB;



class StockHistoryController extends Controller
{
    //
    public function getStockHistory(){
        $data['getRecord'] = StockHistoryModel::getStockHistory();
        $data['getStockCompany'] = StockCompanyModel::getStockCompany();
        #$data['header_title'] = "Admin list";
        return view('admin.stock_history.list',$data);
    }

    public function add(){
        $data['header_title'] = "Add new";
        return view('admin.stock_history.list',$data);
    }

    public function insert(Request $request){
        #dd($request->all()); 
        
        $stock_company_fee_ratio = $request->stock_company_fee_ratio;
        $sh = new StockHistoryModel;
        $sh->transaction_type = trim($request->transaction_type);
        $sh->stock_company_code = trim($request->stock_company);
        $sh->stock_code = trim($request->stock_code);
        $sh->stock_volume = trim($request->stock_volume);
        $sh->stock_price = trim($request->stock_price);
        $sh->stock_date = $request->stock_date;
        //$total_money = $request->stock_volume * $request->stock_price;
        //$total_fee = $request->stock_volume * $request->stock_price * $stock_company_fee_ratio;
        $sh->total_money = $request->stock_volume * $request->stock_price * 1000;
        if($sh->transaction_type == 'Mua'){
            $sh->total_fee = $sh->total_money * $stock_company_fee_ratio / 100;     
        } else {
            $sh->total_fee = $sh->total_money * (0.1 + $stock_company_fee_ratio) / 100;
        }
        
        $sh->stock_company_fee_ratio = $stock_company_fee_ratio;
        $sh->save();
        return redirect('admin/stock_history/list')->with('success', "Thêm bản ghi mới thành công");
    }

    public function edit($id){
        $data['getRecord'] = StockHistoryModel::getSingle($id);
        $data['getStockCompany'] = StockCompanyModel::getStockCompany();
        if(!empty($data['getRecord'])){
            $data['header_title'] = "Edit";
            return view('admin.stock_history.edit',$data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request){
        $sh = StockHistoryModel::getSingle($id);
        $stock_company_fee_ratio = $request->stock_company_fee_ratio;
        $sh->transaction_type = $request->transaction_type;
        $sh->stock_company_code = trim($request->stock_company);
        $sh->stock_code = trim($request->stock_code);
        $sh->stock_volume = trim($request->stock_volume);
        $sh->stock_price = trim($request->stock_price);
        $sh->stock_date = $request->stock_date;
        $sh->total_money = $request->stock_volume * $request->stock_price * 1000;
        if($sh->transaction_type == 'Mua'){
            $sh->total_fee = $sh->total_money * $stock_company_fee_ratio / 100;     
        } else {
            $sh->total_fee = $sh->total_money * (0.1 + $stock_company_fee_ratio) / 100;
        }

        $sh->stock_company_fee_ratio = $stock_company_fee_ratio;
        $sh->is_sold = $request->is_sold;;
        $sh->save();
        return redirect('admin/stock_history/list')->with('success', "Cập nhật bản ghi thành công");
        //return redirect()->back()->back();
    }

    public function delete($id){
        $save = StockHistoryModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        //return redirect('admin/class/list')->with('success', "Calss successfully deleted");
        return redirect()->back()->with('success', "Xóa bản ghi thành công");
    }

    public function getIncreasingStocks(){
        $query = "
            WITH recent_data AS (
                SELECT stock_code, stock_date, price_close
                FROM si.stock
                WHERE stock_date >= DATE_SUB((SELECT MAX(stock_date) FROM si.stock), INTERVAL 10 DAY)
            ),
            ranked AS (
                SELECT stock_code, stock_date, price_close,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date) as rn
                FROM recent_data
            ),
            diff AS (
                SELECT stock_code, stock_date, price_close, rn,
                       CASE WHEN price_close > LAG(price_close) OVER (PARTITION BY stock_code ORDER BY stock_date) THEN 1 ELSE 0 END as is_increase
                FROM ranked
            ),
            grp_cte AS (
                SELECT stock_code, stock_date, price_close, rn,
                       SUM(1 - is_increase) OVER (PARTITION BY stock_code ORDER BY rn) as grp
                FROM diff
            )
            SELECT DISTINCT stock_code
            FROM grp_cte
            GROUP BY stock_code, grp
            HAVING COUNT(*) >= 3
        ";
        $stocks = DB::connection('mysql')->select($query);
        $data['stocks'] = $stocks;
        return view('admin.stock_increasing.list', $data);
    }

    public function getStockData($stock_code){
        $data = DB::connection('mysql')->table('si.stock')
            ->where('stock_code', $stock_code)
            ->orderBy('stock_date')
            ->get(['stock_date', 'price_open', 'price_high', 'price_low', 'price_close', 'volume']);
        return response()->json($data);
    }

    public function getIncreasingStocks3Days(){
        $query = "
            WITH last_3_each_stock AS (
                SELECT stock_code, stock_date, price_close,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date DESC) as rn
                FROM si.stock
                WHERE LENGTH(stock_code) = 3
            ),
            last_3_filtered AS (
                SELECT stock_code, stock_date, price_close
                FROM last_3_each_stock
                WHERE rn <= 3
            ),
            last_3_ordered AS (
                SELECT stock_code, stock_date, price_close,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date) as seq,
                       LAG(price_close) OVER (PARTITION BY stock_code ORDER BY stock_date) as prev_close
                FROM last_3_filtered
            ),
            increase_check AS (
                SELECT stock_code,
                       COUNT(*) as total_records,
                       SUM(CASE WHEN seq > 1 AND price_close > prev_close THEN 1 ELSE 0 END) as increase_count
                FROM last_3_ordered
                GROUP BY stock_code
            )
            SELECT stock_code
            FROM increase_check
            WHERE total_records = 3 AND increase_count = 2
        ";
        $stocks = DB::connection('mysql')->select($query);
        $data['stocks'] = $stocks;
        return view('admin.stock_increasing_3days.list', $data);
    }

    public function getStockData3Days($stock_code){
        $data = DB::connection('mysql')->table('si.stock')
            ->where('stock_code', $stock_code)
            ->orderBy('stock_date')
            ->get(['stock_date', 'price_open', 'price_high', 'price_low', 'price_close', 'volume']);
        return response()->json($data);
    }


    public function getCeilingHighest3Days(){
        $query = "
            WITH last_3_each_stock AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date DESC) as rn
                FROM si.stock
                WHERE LENGTH(stock_code) = 3
            ),
            last_3_filtered AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low
                FROM last_3_each_stock
                WHERE rn <= 3
            ),
            last_3_ordered AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date) as seq,
                       LAG(price_close) OVER (PARTITION BY stock_code ORDER BY stock_date) as prev_close,
                       CASE WHEN price_close = price_high AND price_high = price_open AND price_open = price_low THEN 1 ELSE 0 END as is_ceiling
                FROM last_3_filtered
            ),
            ceiling_check AS (
                SELECT stock_code,
                       COUNT(*) as total_records,
                       SUM(is_ceiling) as ceiling_count,
                       SUM(CASE WHEN seq > 1 AND price_close > prev_close THEN 1 ELSE 0 END) as increase_count
                FROM last_3_ordered
                GROUP BY stock_code
            )
            SELECT stock_code
            FROM ceiling_check
            WHERE total_records = 3 AND ceiling_count = 3 AND increase_count = 2
        ";
        $stocks = DB::connection('mysql')->select($query);
        $data['stocks'] = $stocks;
        return view('admin.stock_ceiling_highest_3days.list', $data);
    }

    public function getCeilingStocks2Days(){
        $query = "
            WITH last_2_each_stock AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low, volume,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date DESC) as rn
                FROM si.stock
                WHERE LENGTH(stock_code) = 3
            ),
            last_2_filtered AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low, volume
                FROM last_2_each_stock
                WHERE rn <= 2
            ),
            last_2_ordered AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low, volume,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date) as seq,
                       LAG(stock_date) OVER (PARTITION BY stock_code ORDER BY stock_date) as prev_date,
                       LAG(price_close) OVER (PARTITION BY stock_code ORDER BY stock_date) as prev_close,
                       CASE WHEN price_close = price_high AND price_high = price_open AND price_open = price_low THEN 1 ELSE 0 END as is_ceiling
                FROM last_2_filtered
            ),
            ceiling_check AS (
                SELECT stock_code,
                       COUNT(*) as total_records,
                       SUM(is_ceiling) as ceiling_count,
                       SUM(CASE WHEN seq > 1 AND price_close > prev_close THEN 1 ELSE 0 END) as increase_count,
                       SUM(CASE WHEN volume > 1000 THEN 1 ELSE 0 END) as vol_count,
                       MAX(stock_date) as latest_date,
                       MIN(stock_date) as earliest_date
                FROM last_2_ordered
                GROUP BY stock_code
            )
            SELECT stock_code
            FROM ceiling_check
            WHERE total_records = 2
              AND ceiling_count = 2
              AND increase_count = 1
              AND vol_count = 2
              AND latest_date >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)
              AND DATEDIFF(latest_date, earliest_date) <= 1
        ";
        $stocks = DB::connection('mysql')->select($query);
        $data['stocks'] = $stocks;
        return view('admin.stock_ceiling_2days.list', $data);
    }

    public function getStockData2Days($stock_code){
        $data = DB::connection('mysql')->table('si.stock')
            ->where('stock_code', $stock_code)
            ->orderBy('stock_date')
            ->get(['stock_date', 'price_open', 'price_high', 'price_low', 'price_close', 'volume']);
        return response()->json($data);
    }

    public function getHighestStocks2Days(){
        $query = "
            WITH last_2_each_stock AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low, volume,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date DESC) as rn
                FROM si.stock
                WHERE LENGTH(stock_code) = 3
            ),
            last_2_filtered AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low, volume
                FROM last_2_each_stock
                WHERE rn <= 2
            ),
            last_2_ordered AS (
                SELECT stock_code, stock_date, price_close, price_high, price_open, price_low, volume,
                       ROW_NUMBER() OVER (PARTITION BY stock_code ORDER BY stock_date) as seq,
                       LAG(stock_date) OVER (PARTITION BY stock_code ORDER BY stock_date) as prev_date,
                       LAG(price_close) OVER (PARTITION BY stock_code ORDER BY stock_date) as prev_close
                FROM last_2_filtered
            ),
            increase_check AS (
                SELECT stock_code,
                       COUNT(*) as total_records,
                       SUM(CASE WHEN seq > 1 AND price_close > prev_close THEN 1 ELSE 0 END) as increase_count,
                       SUM(CASE WHEN volume > 1000 THEN 1 ELSE 0 END) as vol_count,
                       MAX(stock_date) as latest_date,
                       MIN(stock_date) as earliest_date
                FROM last_2_ordered
                GROUP BY stock_code
            )
            SELECT stock_code
            FROM increase_check
            WHERE total_records = 2
              AND increase_count = 1
              AND vol_count = 2
              AND latest_date >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)
              AND DATEDIFF(latest_date, earliest_date) <= 1
        ";
        $stocks = DB::connection('mysql')->select($query);
        $data['stocks'] = $stocks;
        return view('admin.stock_highest_2days.list', $data);
    }
}
