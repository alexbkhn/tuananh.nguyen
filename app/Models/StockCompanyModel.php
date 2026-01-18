<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class StockCompanyModel extends Model
{
    use HasFactory;

    protected $table = 'stock_company';

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getStockCompany(){
        $return = StockCompanyModel::select('stock_company.*')
                ->where('stock_company.is_delete','=',0);
                if(!empty(Request::get('s_stock_company'))){
                    $return = $return->where('stock_company', 'like', '%'.Request::get('s_stock_company').'%');
                }
                if(!empty(Request::get('s_stock_company_code'))){
                    $return = $return->where('stock_company_code', 'like', '%'.Request::get('s_stock_company_code').'%');
                }
                if(!empty(Request::get('s_stock_company_fee_ratio'))){
                    $return = $return->where('stock_company_fee_ratio', '=', Request::get('s_stock_company_fee_ratio'));
                }
                
        $return = $return->orderBy('stock_company_fee_ratio','asc')
                        ->paginate(20);

        return $return;
    }


}
