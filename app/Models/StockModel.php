<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    use HasFactory;

    protected $table = 'stock_history';

    static public function getStockHistory(){
        $return = StockModel::select('stock_history.*')
        ->orderBy('stock_date','desc')
        ->paginate(20);

        return $return;
    }

    
}
