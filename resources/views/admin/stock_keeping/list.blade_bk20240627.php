@extends('layouts.app')

@section('content')
    
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <!-- Bảng lịch sử giao dịch -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="m-0 font-weight-bold text-primary">Danh mục đầu tư</h1>
        </div>

        <!-- Bảng cổ phiếu nắm giữ - Tổng đã mua -->      
        <div class="card-body">
            <div class="text-center">
                <h2 class="h4 font-weight-bold text-gray-900 mb-4">Cổ phiếu nắm giữ</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã chứng khoán</th>
                            <th>Khối lượng mua</th>
                            <th>Trung bình giá mua</th>
                            <th>Tổng tiền mua</th>
                            <th>Tổng phí mua</th>
                            <th>Khối lượng bán</th>
                            <th>Trung bình giá bán</th>
                            <th>Tổng tiền bán</th>
                            <th>Tổng phí bán</th>
                            <th>Lợi nhuận ròng đã bán</th>
                            <th>Tỉ suất lợi nhuận đã bán</th>
                            <th>Khối lượng tồn</th>
                            <th>Giá thị trường</th>
                            <th>Tổng tiền bán giá thị trường</th>
                            <th>Tiền phí bán giá thị trường</th>
                            <th>Lợi nhuận ròng bán giá thị trường</th>
                            <th>Tỉ suất lợi nhuận giá thị trường</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
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
                            (b.price_close * 1000) price_close,
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
                                and sh.is_delete = 0
                                group by sh.stock_code
                            ) shb on sh.stock_code = shb.stock_code
                            where sh.transaction_type = 'Mua'
                            and sh.is_delete = 0
                            group by sh.stock_code
                        ) a
                        left join (
                            SELECT 
                                s.stock_code,
                                round(s.price_close, 2) price_close
                            FROM si.stock s
                            where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                        ) b on a.stock_code = b.stock_code
                        where a.stock_volume_remain > 0
                        order by a.stock_volume_remain desc;
                        ";
                        $result = mysqli_query($conn,$sql_str);
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                            <tr>
                                <td><?=$row['stock_code']?></td>             
                                <td><?=number_format($row['total_volume_in'],0)?></td>
                                <td><?=number_format($row['avg_buy_price'],0)?></td>
                                <td><?=number_format($row['total_buy_money'],0)?></td>
                                <td><?=number_format($row['total_buy_fee'],0)?></td>
                                <td><?=number_format($row['total_volume_out'],0)?></td>
                                <td><?=number_format($row['avg_sell_price'],0)?></td>
                                <td><?=number_format($row['total_sell_money'],0)?></td>
                                <td><?=number_format($row['total_sell_fee'],0)?></td>
                                <td><?=number_format(($row['total_sell_money'] - $row['total_sell_fee'] - $row['avg_buy_price'] * $row['total_volume_out'] * (1 + $row['stock_company_fee_ratio'] / 100)), 0); ?></td>
                                <td><?=number_format((float)(($row['avg_sell_price']/$row['avg_buy_price']-1)*100), 2, '.', ''); ?>%</td>
                                <td><?=number_format($row['stock_volume_remain'],0)?></td>
                                <td><?=number_format($row['price_close'],0)?></td>
                                <td><?=number_format($row['total_money_market_price'],0)?></td>
                                <td><?=number_format($row['total_fee_market_price'],0)?></td>
                                <td><?=number_format(($row['total_money_market_price'] - $row['total_fee_market_price'] - $row['avg_buy_price'] * $row['stock_volume_remain'] * (1 + $row['stock_company_fee_ratio'] / 100)), 0); ?></td>
                                <td><?=number_format((float)(($row['price_close']/$row['avg_buy_price']-1)*100), 2, '.', '');?>%</td>
                            </tr>
                    <?php            
                        }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bảng cổ phiếu nắm giữ - Tách riêng theo giao dịch-->      
        <div class="card-body">
            <div class="text-center">
                <h2 class="h4 font-weight-bold text-gray-900 mb-4">Cổ phiếu nắm giữ (theo giao dịch)</h2>
            </div>
            <form method="get" action="">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Mã chứng khoán</label>
                            <input type="text" class="form-control" placeholder="Mã chứng khoán" name="stock_code">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Trạng thái bán</label>
                            <select class="form-control" name="is_sold"> 
                                <option value="">Tất cả</option>
                                <option value="1">Chưa bán</option>
                                <option value="2">Đã bán</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">  
                            <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                            <a href="{{ url('admin/stock_keeping/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã chứng khoán</th>
                            <th>Thời gian mua CP</th>
                            <th>Khối lượng mua</th>
                            <th>Trung bình giá mua</th>
                            <th>Tổng tiền mua</th>
                            <th>Tổng phí mua</th>
                            <th>Giá thị trường</th>
                            <th>Tổng tiền bán giá thị trường</th>
                            <th>Tiền phí bán giá thị trường</th>
                            <th>Lợi nhuận ròng bán giá thị trường</th>
                            <th>Tỉ suất lợi nhuận</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                        $conn = mysqli_connect("localhost","root","123456","si");
                        if(isset($_GET['stock_code']) && $_GET['stock_code'] != '' && isset($_GET['is_sold']) && $_GET['is_sold'] != ''){
                            $stock_code = $_GET['stock_code'];
                            $is_sold = $_GET['is_sold'];
                            $sql_str = "
                                select 
                                    a.id,
                                    a.stock_code,
                                    date(a.stock_date) stock_date,
                                    a.total_volume_in,
                                    a.avg_buy_price,
                                    a.total_buy_money,
                                    a.total_buy_fee,
                                    b.price_close,
                                    (b.price_close * a.total_volume_in * 1000) total_money_market_price,
                                    (b.price_close * a.total_volume_in * 10 * (a.stock_company_fee_ratio + 0.1)) total_fee_market_price,
                                    a.stock_company_fee_ratio,
                                    a.is_sold
                                from
                                (
                                    select 
                                        sh.id,
                                        sh.stock_code, 
                                        sh.stock_date,
                                        sh.stock_volume total_volume_in, 
                                        (sh.stock_price) avg_buy_price, 
                                        sh.total_money total_buy_money,
                                        sh.total_fee total_buy_fee,
                                        sh.stock_company_fee_ratio stock_company_fee_ratio,
                                        sh.is_sold
                                    from si.stock_history sh
                                    where sh.transaction_type = 'Mua'
                                    and sh.is_delete = 0
                                    order by sh.stock_code, sh.stock_date desc
                                ) a
                                left join (
                                    SELECT 
                                        s.stock_code,
                                        round(s.price_close, 2) price_close
                                    FROM si.stock s
                                    where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                ) b on a.stock_code = b.stock_code
                                where a.stock_code = '$stock_code'
                                and is_sold = '$is_sold'
                                order by a.stock_code asc, a.stock_date desc;
                            ";
                        } else if(isset($_GET['is_sold']) && $_GET['is_sold'] != ''){
                            $stock_code = $_GET['stock_code'];
                            $is_sold = $_GET['is_sold'];
                            $sql_str = "
                                select 
                                    a.id,
                                    a.stock_code,
                                    date(a.stock_date) stock_date,
                                    a.total_volume_in,
                                    a.avg_buy_price,
                                    a.total_buy_money,
                                    a.total_buy_fee,
                                    b.price_close,
                                    (b.price_close * a.total_volume_in * 1000) total_money_market_price,
                                    (b.price_close * a.total_volume_in * 10 * (a.stock_company_fee_ratio + 0.1)) total_fee_market_price,
                                    a.stock_company_fee_ratio,
                                    a.is_sold
                                from
                                (
                                    select 
                                        sh.id,
                                        sh.stock_code, 
                                        sh.stock_date,
                                        sh.stock_volume total_volume_in, 
                                        (sh.stock_price) avg_buy_price, 
                                        sh.total_money total_buy_money,
                                        sh.total_fee total_buy_fee,
                                        sh.stock_company_fee_ratio stock_company_fee_ratio,
                                        sh.is_sold
                                    from si.stock_history sh
                                    where sh.transaction_type = 'Mua'
                                    and sh.is_delete = 0
                                    order by sh.stock_code, sh.stock_date desc
                                ) a
                                left join (
                                    SELECT 
                                        s.stock_code,
                                        round(s.price_close, 2) price_close
                                    FROM si.stock s
                                    where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                ) b on a.stock_code = b.stock_code
                                where 1=1
                                and is_sold = '$is_sold'
                                order by a.stock_code asc, a.stock_date desc;
                            ";
                        } else if(isset($_GET['stock_code']) && $_GET['stock_code'] != ''){
                            $stock_code = $_GET['stock_code'];
                            $is_sold = $_GET['is_sold'];
                            $sql_str = "
                                select 
                                    a.id,
                                    a.stock_code,
                                    date(a.stock_date) stock_date,
                                    a.total_volume_in,
                                    a.avg_buy_price,
                                    a.total_buy_money,
                                    a.total_buy_fee,
                                    b.price_close,
                                    (b.price_close * a.total_volume_in * 1000) total_money_market_price,
                                    (b.price_close * a.total_volume_in * 10 * (a.stock_company_fee_ratio + 0.1)) total_fee_market_price,
                                    a.stock_company_fee_ratio,
                                    a.is_sold
                                from
                                (
                                    select 
                                        sh.id,
                                        sh.stock_code, 
                                        sh.stock_date,
                                        sh.stock_volume total_volume_in, 
                                        (sh.stock_price) avg_buy_price, 
                                        sh.total_money total_buy_money,
                                        sh.total_fee total_buy_fee,
                                        sh.stock_company_fee_ratio stock_company_fee_ratio,
                                        sh.is_sold
                                    from si.stock_history sh
                                    where sh.transaction_type = 'Mua'
                                    and sh.is_delete = 0
                                    order by sh.stock_code, sh.stock_date desc
                                ) a
                                left join (
                                    SELECT 
                                        s.stock_code,
                                        round(s.price_close, 2) price_close
                                    FROM si.stock s
                                    where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                ) b on a.stock_code = b.stock_code
                                where a.stock_code = '$stock_code'
                                order by a.stock_code asc, a.stock_date desc;
                            ";
                        } else {
                            $sql_str = "
                                select 
                                    a.id,
                                    a.stock_code,
                                    date(a.stock_date) stock_date,
                                    a.total_volume_in,
                                    a.avg_buy_price,
                                    a.total_buy_money,
                                    a.total_buy_fee,
                                    b.price_close,
                                    (b.price_close * a.total_volume_in * 1000) total_money_market_price,
                                    (b.price_close * a.total_volume_in * 10 * (a.stock_company_fee_ratio + 0.1)) total_fee_market_price,
                                    a.stock_company_fee_ratio,
                                    a.is_sold
                                from
                                (
                                    select 
                                        sh.id,
                                        sh.stock_code, 
                                        sh.stock_date,
                                        sh.stock_volume total_volume_in, 
                                        (sh.stock_price) avg_buy_price, 
                                        sh.total_money total_buy_money,
                                        sh.total_fee total_buy_fee,
                                        sh.stock_company_fee_ratio stock_company_fee_ratio,
                                        sh.is_sold
                                    from si.stock_history sh
                                    where sh.transaction_type = 'Mua'
                                    and sh.is_delete = 0
                                    order by sh.stock_code, sh.stock_date desc
                                ) a
                                left join (
                                    SELECT 
                                        s.stock_code,
                                        round(s.price_close, 2) price_close
                                    FROM si.stock s
                                    where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                                ) b on a.stock_code = b.stock_code
                                order by a.stock_code asc, a.stock_date desc;
                            ";
                        }
                        
                        $result = mysqli_query($conn,$sql_str);
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                            <tr>
                                <td><?=$row['stock_code']?></td>       
                                <td><?=$row['stock_date']?></td>   
                                <td><?=$row['total_volume_in']?></td>
                                <td><?=number_format($row['avg_buy_price'],0)?></td>
                                <td><?=number_format($row['total_buy_money'],0)?></td>
                                <td><?=number_format($row['total_buy_fee'],0)?></td>
                                <td><?=number_format($row['price_close']*1000,0)?></td>
                                <td><?=number_format($row['total_money_market_price'],0)?></td>
                                <td><?=number_format($row['total_fee_market_price'],0)?></td>
                                <td><?=number_format($row['total_money_market_price'] - $row['total_buy_money'] - $row['total_buy_fee'] - $row['total_fee_market_price'], 0); ?></td>
                                <td><?=number_format((float)(($row['price_close']*1000/$row['avg_buy_price']-1)*100), 2, '.', '');?>%</td>
                                <td class="is_sold">@if ($row['is_sold'] == 1) Chưa bán @else Đã bán @endif</td>
                                <td>
                                    <a class="btn btn-warning" href="{{ url('admin/stock_history/edit/'.$row['id']) }}">Sửa
                                    </a>
                                </td>
                            </tr>
                    <?php            
                        }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bảng cổ phiếu đã bán -->      
        <div class="card-body">
            <div class="text-center">
                <h2 class="h4 font-weight-bold text-gray-900 mb-4">Cổ phiếu đã bán</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã chứng khoán</th>
                            <th>Khối lượng mua</th>
                            <th>Trung bình giá mua</th>
                            <th>Tổng tiền mua</th>
                            <th>Tổng phí mua</th>
                            <th>Khối lượng bán</th>
                            <th>Trung bình giá bán</th>
                            <th>Tổng tiền bán</th>
                            <th>Tổng phí bán</th>
                            <th>Lợi nhuận ròng đã bán</th>
                            <th>Tỉ suất lợi nhuận đã bán</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
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
                                and sh.is_delete = 0
                                group by sh.stock_code
                            ) shb on sh.stock_code = shb.stock_code
                            where sh.transaction_type = 'Mua'
                            and sh.is_delete = 0
                            group by sh.stock_code
                        ) a
                        left join (
                            SELECT 
                                s.stock_code,
                                round(s.price_close, 2) price_close
                            FROM si.stock s
                            where s.stock_date = (SELECT max(s.stock_date) stock_date FROM si.stock s)
                        ) b on a.stock_code = b.stock_code
                        where a.stock_volume_remain = 0
                        order by a.stock_volume_remain desc;
                        ";
                        $result = mysqli_query($conn,$sql_str);
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                            <tr>
                                <td><?=$row['stock_code']?></td>             
                                <td><?=$row['total_volume_in']?></td>
                                <td><?=number_format($row['avg_buy_price'],0)?></td>
                                <td><?=number_format($row['total_buy_money'],0)?></td>
                                <td><?=number_format($row['total_buy_fee'],0)?></td>
                                <td><?=$row['total_volume_out']?></td>
                                <td><?=number_format($row['avg_sell_price'],0)?></td>
                                <td><?=number_format($row['total_sell_money'],0)?></td>
                                <td><?=number_format($row['total_sell_fee'],0)?></td>
                                <td><?=number_format($row['total_sell_money'] - $row['total_sell_fee'] - $row['avg_buy_price'] * $row['total_volume_out'] * (1 + $row['stock_company_fee_ratio'] / 100),0) ?></td>
                                <td><?=number_format(($row['avg_sell_price']/$row['avg_buy_price']-1)*100,2)?>%</td>
                            </tr>
                    <?php            
                        }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
        
    </div>



    </section>
</div>

@endsection