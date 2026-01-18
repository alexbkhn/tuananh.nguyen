<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TestStockKeepingModel;
use App\Models\StockCompanyModel;
use Auth;



class TestStockKeepingController extends Controller
{
    //

    public function getStockKeeping(){
        $data['getRecord'] = TestStockKeepingModel::getStockKeeping();
        $data['getStockCompany'] = StockCompanyModel::getStockCompany();
        #$data['header_title'] = "Admin list";
        return view('admin.test_stock_keeping.list',$data);
    }

    public function add(){
        $data['header_title'] = "Add new";
        return view('admin.test_stock_keeping.list',$data);
    }

    public function insert(Request $request){
        #dd($request->all()); 
        $stock_company_fee_ratio = $request->stock_company_fee_ratio;
        $sh = new TestStockKeepingModel;
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
        return redirect('admin/test_stock_keeping/list')->with('success', "Thêm bản ghi mới thành công");
    }
}
