<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;


class NavHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'stock_nav';

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getNavHistory(){
        $return = NavHistoryModel::select('stock_nav.*')
                ->where('stock_nav.is_delete','=',0);
                if(!empty(Request::get('s_stock_company_code'))){
                    $return = $return->where('stock_company_code', 'like', '%'.Request::get('s_stock_company').'%');
                }
                if(!empty(Request::get('s_note'))){
                    $return = $return->where('note', 'like', '%'.Request::get('s_note').'%');
                }
                if(!empty(Request::get('s_nav_date'))){
                    $return = $return->where('nav_date', '=', Request::get('s_nav_date'));
                }
                if(!empty(Request::get('s_transaction_type'))){
                    $return = $return->where('transaction_type', '=', Request::get('s_transaction_type'));
                }
                
        $return = $return->orderBy('nav_date','desc')
                        ->paginate(7);

        return $return;
    }
}
