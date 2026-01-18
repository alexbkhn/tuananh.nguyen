<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class TestStockKeepingModel extends Model
{
    use HasFactory;

    protected $table = 'test_stock_history';

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getStockKeeping(){
            $conn = mysqli_connect("localhost","root","123456","si");
            $sql_str = "
                        select 
                            a.stock_code,
                            a.stock_volume_remain,
                            a.total_volume_in,
                            a.avg_buy_price,
                            a.total_buy_money,
                            round(a.total_buy_fee,0) total_buy_fee,
                            a.total_volume_out,
                            a.avg_sell_price,
                            a.total_sell_money,
                            round(a.total_sell_fee,0) total_sell_fee,
                            b.price_close,
                            (b.price_close * a.stock_volume_remain * 1000) total_money_market_price,
                            (b.price_close * a.stock_volume_remain * 10 * (a.stock_company_fee_ratio + 0.1)) total_fee_market_price,
                            a.stock_company_fee_ratio
                        from
                        (
                            select 
                                sh.stock_code stock_code, 
                                (sum(sh.stock_volume) - sum(ifnull(shb.stock_volume,0))) stock_volume_remain,
                                sum(sh.stock_volume) total_volume_in, 
                                sum(sh.total_money)/sum(sh.stock_volume) avg_buy_price, 
                                sum(sh.total_money) total_buy_money,
                                sum(sh.total_fee) total_buy_fee,
                                sum(shb.stock_volume) total_volume_out, 
                                sum(shb.total_money)/sum(shb.stock_volume) avg_sell_price, 
                                sum(shb.total_money) total_sell_money,
                                sum(shb.total_fee) total_sell_fee,
                                round(avg(sh.stock_company_fee_ratio),3) stock_company_fee_ratio
                            from si.test_stock_history sh
                            left join(
                                select 
                                    sh.stock_code stock_code, 
                                    sum(sh.stock_volume) stock_volume, 
                                    sum(sh.total_money)/sum(sh.stock_volume) avg_price, 
                                    sum(sh.total_money) total_money,
                                    sum(sh.total_fee) total_fee
                                from si.test_stock_history sh
                                where sh.transaction_type = 'Bán'
                                group by sh.stock_code
                            ) shb on sh.stock_code = shb.stock_code
                            where sh.transaction_type = 'Mua'
                            and sh.is_delete = 0
                            group by sh.stock_code
                        ) a
                        left join (
                            SELECT 
                                s.stock_code,
                                CONVERT(s.price_close, SIGNED) price_close
                            FROM si.stock s
                            where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                        ) b on a.stock_code = b.stock_code
                        where a.stock_volume_remain > 0
                        order by a.stock_volume_remain desc;
                        ";
                        $result = mysqli_query($conn,$sql_str);

        return $result;
    }

}
