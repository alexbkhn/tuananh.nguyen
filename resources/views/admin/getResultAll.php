<!-- Kết quả thực hiện

<?php
                                                    $conn = mysqli_connect("localhost","root","123456","si");
                                                    //Tiền nạp
                                                    $sql_str = "SELECT sum(total_money) as r_in FROM si.stock_nav WHERE transaction_type = 'Nạp'";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $r_in = mysqli_fetch_assoc($res);
                                                    $r_in1 = $r_in['r_in'];
                                                    //Tiền rút
                                                    $sql_str = "SELECT sum(total_money) as r_out FROM si.stock_nav WHERE transaction_type = 'Rút'";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $r_out = mysqli_fetch_assoc($res);
                                                    $r_out1 = $r_out['r_out'];
                                                    //Tiền lãi
                                                    $sql_str = "SELECT sum(total_money) as r_out FROM si.stock_nav WHERE transaction_type = 'Lãi'";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $tong_tien_cong_them1 = mysqli_fetch_assoc($res);
                                                    $tong_tien_cong_them = $tong_tien_cong_them1['r_out'];
                                                    //Tiền phí
                                                    $sql_str = "SELECT sum(total_money) as r_out FROM si.stock_nav WHERE transaction_type = 'Phí'";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $tong_tien_tru_phi1 = mysqli_fetch_assoc($res);
                                                    $tong_tien_tru_phi = $tong_tien_tru_phi1['r_out'];
                                                    //Tiền còn lại
                                                    $r_nav = $r_in1 - $r_out1;
                                                    //Tiền mua CP
                                                    $sql_str = "select 
                                                            sum(a.total_buy_money) r_in
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
                                                            from si.stock_history sh
                                                            left join(
                                                                select 
                                                                    sh.stock_code stock_code, 
                                                                    sum(sh.stock_volume) stock_volume, 
                                                                    sum(sh.total_money)/sum(sh.stock_volume) avg_price, 
                                                                    sum(sh.total_money) total_money,
                                                                    sum(sh.total_fee) total_fee
                                                                from si.stock_history sh
                                                                where sh.transaction_type = 'Bán'
                                                                group by sh.stock_code
                                                            ) shb on sh.stock_code = shb.stock_code
                                                            where sh.transaction_type = 'Mua'
                                                            group by sh.stock_code
                                                        ) a
                                                        left join (
                                                            SELECT 
                                                                s.stock_code,
                                                                CONVERT(s.price_close, SIGNED) price_close
                                                            FROM si.stock s
                                                            where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                                        ) b on a.stock_code = b.stock_code
                                                        where a.stock_volume_remain > 0;                                                    
                                                    ";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $r_in = mysqli_fetch_assoc($res);
                                                    $r_in1 = $r_in['r_in'];
                                                    //Tiền bán CP
                                                    $sql_str = "
                                                        select
                                                            ifnull(sum(a.total_sell_money),0) r_out
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
                                                            from si.stock_history sh
                                                            left join(
                                                                select 
                                                                    sh.stock_code stock_code, 
                                                                    sum(sh.stock_volume) stock_volume, 
                                                                    sum(sh.total_money)/sum(sh.stock_volume) avg_price, 
                                                                    sum(sh.total_money) total_money,
                                                                    sum(sh.total_fee) total_fee
                                                                from si.stock_history sh
                                                                where sh.transaction_type = 'Bán'
                                                                group by sh.stock_code
                                                            ) shb on sh.stock_code = shb.stock_code
                                                            where sh.transaction_type = 'Mua'
                                                            group by sh.stock_code
                                                        ) a
                                                        left join (
                                                            SELECT 
                                                                s.stock_code,
                                                                CONVERT(s.price_close, SIGNED) price_close
                                                            FROM si.stock s
                                                            where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                                        ) b on a.stock_code = b.stock_code
                                                        where a.stock_volume_remain > 0;
                                                    ";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $r_out = mysqli_fetch_assoc($res);
                                                    $r_out1 = $r_out['r_out'];
            
                                                    //Tiền mua cổ phiếu
                                                    $r_nav_in_stock = $r_in1 - $r_out1;
                                                    //Doanh thu theo giá thị trường
                                                    $sql_str = "
                                                        select 
                                                            ifnull(sum((b.price_close * a.stock_volume_remain * 1000)),0) total_money_market_price
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
                                                            from si.stock_history sh
                                                            left join(
                                                                select 
                                                                    sh.stock_code stock_code, 
                                                                    sum(sh.stock_volume) stock_volume, 
                                                                    sum(sh.total_money)/sum(sh.stock_volume) avg_price, 
                                                                    sum(sh.total_money) total_money,
                                                                    sum(sh.total_fee) total_fee
                                                                from si.stock_history sh
                                                                where sh.transaction_type = 'Bán'
                                                                group by sh.stock_code
                                                            ) shb on sh.stock_code = shb.stock_code
                                                            where sh.transaction_type = 'Mua'
                                                            group by sh.stock_code
                                                        ) a
                                                        left join (
                                                            SELECT 
                                                                s.stock_code,
                                                                CONVERT(s.price_close, SIGNED) price_close
                                                            FROM si.stock s
                                                            where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                                        ) b on a.stock_code = b.stock_code
                                                        order by a.stock_volume_remain desc;                                                  
                                                    ";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $tong_tien_ban_gia_thi_truong_cp = mysqli_fetch_assoc($res);
                                                    $tong_tien_ban_gia_thi_truong = $tong_tien_ban_gia_thi_truong_cp['total_money_market_price'];
                                                    //Tổng tiền mua
                                                    $sql_str = "
                                                        select 
                                                            ifnull(round(sum(a.total_buy_money),0),0) r_in
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
                                                            from si.stock_history sh
                                                            left join(
                                                                select 
                                                                    sh.stock_code stock_code, 
                                                                    sum(sh.stock_volume) stock_volume, 
                                                                    sum(sh.total_money)/sum(sh.stock_volume) avg_price, 
                                                                    sum(sh.total_money) total_money,
                                                                    sum(sh.total_fee) total_fee
                                                                from si.stock_history sh
                                                                where sh.transaction_type = 'Bán'
                                                                group by sh.stock_code
                                                            ) shb on sh.stock_code = shb.stock_code
                                                            where sh.transaction_type = 'Mua'
                                                            group by sh.stock_code
                                                        ) a
                                                        left join (
                                                            SELECT 
                                                                s.stock_code,
                                                                CONVERT(s.price_close, SIGNED) price_close
                                                            FROM si.stock s
                                                            where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                                        ) b on a.stock_code = b.stock_code;                                                  
                                                    ";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $tong_tien_mua_cp = mysqli_fetch_assoc($res);
                                                    $tong_tien_mua = $tong_tien_mua_cp['r_in'];
                                                    //Tổng tiền bán
                                                    $sql_str = "
                                                        select
                                                            ifnull(round(sum(a.total_sell_money),0),0) r_out
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
                                                            from si.stock_history sh
                                                            left join(
                                                                select 
                                                                    sh.stock_code stock_code, 
                                                                    sum(sh.stock_volume) stock_volume, 
                                                                    sum(sh.total_money)/sum(sh.stock_volume) avg_price, 
                                                                    sum(sh.total_money) total_money,
                                                                    sum(sh.total_fee) total_fee
                                                                from si.stock_history sh
                                                                where sh.transaction_type = 'Bán'
                                                                group by sh.stock_code
                                                            ) shb on sh.stock_code = shb.stock_code
                                                            where sh.transaction_type = 'Mua'
                                                            group by sh.stock_code
                                                        ) a
                                                        left join (
                                                            SELECT 
                                                                s.stock_code,
                                                                CONVERT(s.price_close, SIGNED) price_close
                                                            FROM si.stock s
                                                            where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                                        ) b on a.stock_code = b.stock_code;
                                                    ";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $tong_tien_ban_cp = mysqli_fetch_assoc($res);
                                                    $tong_tien_ban = $tong_tien_ban_cp['r_out'];
                                                    //Tổng phí mua
                                                    $sql_str = "
                                                    select
                                                        ifnull(round(sum(a.total_buy_fee),0),0) r_out
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
                                                        from si.stock_history sh
                                                        left join(
                                                            select 
                                                                sh.stock_code stock_code, 
                                                                sum(sh.stock_volume) stock_volume, 
                                                                sum(sh.total_money)/sum(sh.stock_volume) avg_price, 
                                                                sum(sh.total_money) total_money,
                                                                sum(sh.total_fee) total_fee
                                                            from si.stock_history sh
                                                            where sh.transaction_type = 'Bán'
                                                            group by sh.stock_code
                                                        ) shb on sh.stock_code = shb.stock_code
                                                        where sh.transaction_type = 'Mua'
                                                        group by sh.stock_code
                                                    ) a
                                                    left join (
                                                        SELECT 
                                                            s.stock_code,
                                                            CONVERT(s.price_close, SIGNED) price_close
                                                        FROM si.stock s
                                                        where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                                    ) b on a.stock_code = b.stock_code;
                                                    ";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $tong_phi_mua_cp = mysqli_fetch_assoc($res);
                                                    $tong_phi_mua = $tong_phi_mua_cp['r_out'];
                                                    //Tổng phí bán
                                                    $sql_str = "
                                                    select
                                                        ifnull(round(sum(a.total_sell_fee),0),0) r_out
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
                                                        from si.stock_history sh
                                                        left join(
                                                            select 
                                                                sh.stock_code stock_code, 
                                                                sum(sh.stock_volume) stock_volume, 
                                                                sum(sh.total_money)/sum(sh.stock_volume) avg_price, 
                                                                sum(sh.total_money) total_money,
                                                                sum(sh.total_fee) total_fee
                                                            from si.stock_history sh
                                                            where sh.transaction_type = 'Bán'
                                                            group by sh.stock_code
                                                        ) shb on sh.stock_code = shb.stock_code
                                                        where sh.transaction_type = 'Mua'
                                                        group by sh.stock_code
                                                    ) a
                                                    left join (
                                                        SELECT 
                                                            s.stock_code,
                                                            CONVERT(s.price_close, SIGNED) price_close
                                                        FROM si.stock s
                                                        where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                                    ) b on a.stock_code = b.stock_code;
                                                    ";
                                                    $result = mysqli_query($conn,$sql_str);
                                                    $res = mysqli_query($conn, $sql_str);
                                                    $tong_phi_ban_cp = mysqli_fetch_assoc($res);
                                                    $tong_phi_ban = $tong_phi_ban_cp['r_out'];
                                                    //Tiền mặt khả dụng
                                                    $tien_du_tkck = $r_nav - $tong_tien_mua - $tong_phi_mua + $tong_tien_ban - $tong_phi_ban + $tong_tien_cong_them - $tong_tien_tru_phi;
                                                ?>

Kết thúc kết quả thực hiện -->