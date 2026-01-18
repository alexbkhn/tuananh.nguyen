<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\StockKeepingModel;
use Auth;



class StockKeepingController extends Controller
{
    //
    public function getStockKeeping(){
        $data['getRecord'] = StockKeepingModel::getStockKeeping();
        #$data['header_title'] = "Admin list";
        return view('admin.stock_keeping.list',$data);
    }
}
