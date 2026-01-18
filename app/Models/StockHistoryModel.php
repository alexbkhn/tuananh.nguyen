<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class StockHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'stock_history';

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getStockHistory(){
        $return = StockHistoryModel::select('stock_history.*')
                ->where('stock_history.is_delete','=',0);
                if(!empty(Request::get('s_stock_company'))){
                    $return = $return->where('stock_company_code', 'like', '%'.Request::get('s_stock_company').'%');
                }
                if(!empty(Request::get('s_stock_code'))){
                    $return = $return->where('stock_code', 'like', '%'.Request::get('s_stock_code').'%');
                }
                if(!empty(Request::get('s_stock_date'))){
                    $return = $return->where('stock_date', '=', Request::get('s_stock_date'));
                }
                if(!empty(Request::get('s_transaction_type'))){
                    $return = $return->where('transaction_type', '=', Request::get('s_transaction_type'));
                }
                if(!empty(Request::get('s_is_sold'))){
                    $return = $return->where('is_sold', '=', Request::get('s_is_sold'));
                    //$return = $return->where('is_sold', 'like', '%'.Request::get('s_is_sold').'%');
                }
                
        $return = $return->orderBy('stock_date','desc')
                        ->paginate(20);

        return $return;
    }
/*
    static public function getFeeRatio($input_stock_company_code){
        $return = StockHistoryModel::select('stock_company.stock_company_fee_ratio as stock_company_fee_ratio')
                ->rightjoin('stock_company', 'stock_company.stock_company_code', 'stock_history.stock_company_code')
                ->where('stock_company.stock_company_code','=',$input_stock_company_code);
        return $return;
    }
*/
    //static public function getStockHistory(){
    //          $return = StockHistoryModel::select('stock_history.*')
    //            ->where('stock_history.is_delete','=',0)
    //            ->orderBy('stock_date','desc')
    //            ->paginate(20);

    //    return $return;
    //}

    /* static public function getStockHistory(){
        $return = StockHistoryModel::select('stock_history.*')
                ->where('stock_history.is_delete','=',0);
                if(!empty(Request::get('s_stock_company'))){
                    $return = $return->where('stock_company_code', 'like', '%'.Request::get('s_stock_company').'%');
                }
                if(!empty(Request::get('s_stock_code'))){
                    $return = $return->where('stock_code', 'like', '%'.Request::get('s_stock_code').'%');
                }
                if(!empty(Request::get('s_stock_date'))){
                    $return = $return->where('stock_date', '=', Request::get('s_stock_date'));
                }
                if(!empty(Request::get('s_transaction_type'))){
                    $return = $return->where('transaction_type', '=', Request::get('s_transaction_type'));
                }
                if(!empty(Request::get('s_is_sold'))){
                    $return = $return->where('is_sold', '=', Request::get('s_is_sold'));
                    //$return = $return->where('is_sold', 'like', '%'.Request::get('s_is_sold').'%');
                }
                
        $return = $return->orderBy('stock_date','desc')
                        ->paginate(20);

        return $return;
    } */


}
