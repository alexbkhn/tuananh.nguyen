<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockModel;
use Hash;
use Auth;

class StockController extends Controller
{
    public function getStockHistory(){
        $data['getRecord'] = StockModel::getStockHistory();
        #$data['header_title'] = "Admin list";
        return view('admin.stock.stock_history',$data);
    }

    public function insert(Request $request){
        #dd($request->all());
        $total_money = $request->stock_volume * $request->stock_price;
        $total_fee = $total_money * 0.027 / 100;
        $save = new StockModel;
        $save->transaction_type = trim($request->transaction_type);
        $save->stock_company_code = trim($request->stock_company);
        $save->stock_code = trim($request->stock_code);
        $save->stock_volume = trim($request->stock_volume);
        $save->stock_price = trim($request->stock_price);
        $save->stock_date = $request->stock_date;
        $save->total_money = $total_money;
        $save->total_fee = $total_fee;
        $save->stock_company_fee_ratio = 0.027;
        $save->save();
        return redirect('admin/stock/stock_history')->with('success', "Class successfully created");
    }
    

}