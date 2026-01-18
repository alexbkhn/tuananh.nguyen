<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;


class NavSavingsModel extends Model
{
    use HasFactory;

    protected $table = 'nav_savings';

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getNavHistory(){
        $return = NavSavingsModel::select('nav_savings.*')
                ->where('nav_savings.is_delete','=',0);
                if(!empty(Request::get('s_bank_code'))){
                    $return = $return->where('bank_code', 'like', '%'.Request::get('s_bank_code').'%');
                }
                if(!empty(Request::get('s_note'))){
                    $return = $return->where('note', 'like', '%'.Request::get('s_note').'%');
                }
                
        $return = $return->orderBy('end_time','asc')
                        ->paginate(7);

        return $return;
    }
}
