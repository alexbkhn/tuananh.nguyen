@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh mục đầu tư thử nghiệm</h1>
                </div>
                <!-- /.container-fluid 
          <div class="col-sm-6" style="text-align: right;">
            <a href="{{ url('admin/stock_history/add') }}" class="btn btn-primary"> Thêm mới </a>
          </div>
          -->
            </div>
        </div>
    </section>

    <!-- THÊM MỚI GIAO DỊCH -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thêm mới giao dịch thử nghiệm</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="">
                            {{ csrf_field() }}
                            <div class="form-group row"> </div>
                            <div class="form-group row">
                                <div class="col-sm-2 mb-3 mb-sm-0" style="margin-left: 25px;">
                                    <select class="form-control" required id="transaction_type" name="transaction_type" placeholder="Loại giao dịch">
                                        <option value="" disabled selected>Loại giao dịch</option>
                                        <option value="Mua">Mua</option>
                                        <option value="Bán">Bán</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">

                                    <!-- 
                      <input type="text" class="form-control" id="stock_company" name="stock_company"
                          placeholder="Công ty chứng khoán">
                    -->
                                    <select class="form-control" id="stock_company" name="stock_company" required>
                                        <option value="" disabled selected>Công ty chứng khoán</option>
                                        @foreach($getStockCompany as $stock_company_1)
                                        <option value="{{ $stock_company_1->stock_company_code }}">{{ $stock_company_1->stock_company_code }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-sm-1 mb-3 mb-sm-0">
                                    <select class="form-control" id="stock_company_fee_ratio" name="stock_company_fee_ratio" required>
                                        <option value="" disabled selected>Phí giao dịch</option>
                                        @foreach($getStockCompany as $stock_company_1)
                                        <option value="{{ $stock_company_1->stock_company_fee_ratio }}">{{ $stock_company_1->stock_company_code }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <input type="text" class="form-control" id="stock_code" name="stock_code" required placeholder="Mã chứng khoán">
                                </div>
                                <div class="col-sm-1">
                                    <input type="int" class="form-control" id="stock_volume" name="stock_volume" required placeholder="Số lượng">
                                </div>
                                <div class="col-sm-1">
                                    <input type="float" class="form-control" id="stock_price" name="stock_price" required placeholder="Giá">
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <input placeholder="Thời gian giao dịch" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="stock_date" name="stock_date" required />
                                </div>
                                <button class="btn btn-primary">Tạo mới</button> <!--style="margin-left: 150px;"..-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Cổ phiếu nắm giữ (theo giao dịch) -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    @include('_message')
                    <!-- /.card -->

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title card-primary">Giao dịch thử nghiệm</h3>
                        </div>
                        <form method="get" action="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label>Mã chứng khoán</label>
                                        <input type="text" class="form-control" placeholder="Mã chứng khoán" name="stock_code">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Trạng thái</label>
                                        <select class="form-control" name="is_sold">
                                            <option value="">Tất cả</option>
                                            <option value="1">Chưa bán</option>
                                            <option value="2">Đã bán</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                        <a href="{{ url('admin/test_stock_keeping/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
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
                                        <th>Lợi nhuận ròng</th> <!-- bán giá thị trường -->
                                        <th>Tỉ suất lợi nhuận</th>
                                        <!-- <th>Trạng thái</th> -->
                                        <th>Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $conn = mysqli_connect("localhost", "root", "123456", "si");
                                    if (isset($_GET['stock_code']) && $_GET['stock_code'] != '' && isset($_GET['is_sold']) && $_GET['is_sold'] != '') {
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
                                    a.is_sold,
                                    (b.price_close/a.avg_buy_price-1)*100 benifit_ratio
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
                                    from si.test_stock_history sh
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
                                order by benifit_ratio desc;
                            ";
                                    } else if (isset($_GET['is_sold']) && $_GET['is_sold'] != '') {
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
                                    a.is_sold,
		                            (b.price_close/a.avg_buy_price-1)*100 benifit_ratio
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
                                    from si.test_stock_history sh
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
                                order by benifit_ratio desc;
                            ";
                                    } else if (isset($_GET['stock_code']) && $_GET['stock_code'] != '') {
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
                                    a.is_sold,
		                            (b.price_close/a.avg_buy_price-1)*100 benifit_ratio
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
                                    from si.test_stock_history sh
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
                                order by benifit_ratio desc;
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
                                    a.is_sold,
		                            (b.price_close/a.avg_buy_price-1)*100 benifit_ratio
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
                                    from si.test_stock_history sh
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
                                order by benifit_ratio desc;
                            ";
                                    }

                                    $result = mysqli_query($conn, $sql_str);
                                    mysqli_close($conn);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?= $row['stock_code'] ?></td>
                                            <td><?= $row['stock_date'] ?></td>
                                            <td><?= $row['total_volume_in'] ?></td>
                                            <td><?= number_format($row['avg_buy_price'], 2) ?></td>
                                            <td><?= number_format($row['total_buy_money'], 0) ?></td>
                                            <td><?= number_format($row['total_buy_fee'], 0) ?></td>
                                            <td><?= number_format($row['price_close'] * 1000, 0) ?></td>
                                            <td><?= number_format($row['total_money_market_price'], 0) ?></td>
                                            <td><?= number_format($row['total_fee_market_price'], 0) ?></td>
                                            <td><?= number_format($row['total_money_market_price'] - $row['total_buy_money'] - $row['total_buy_fee'] - $row['total_fee_market_price'], 0); ?></td>
                                            <td><?= number_format((float)(($row['price_close'] / $row['avg_buy_price'] - 1) * 100), 2, '.', ''); ?>%</td>
                                            <!-- <td class="is_sold">@if ($row['is_sold'] == 1) Chưa bán @else Đã bán @endif</td> -->
                                            <td>
                                                <!-- 
                                    <a href="{{ url('admin/test_stock_history/edit/'.$row['id']) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ url('admin/test_stock_history/delete/'.$row['id']) }}" class="btn btn-danger">Delete</a> 
                                    <a class="btn btn-warning" href="{{ url('admin/test_stock_history/edit/'.$row['id']) }}">Sửa</a>
                                    -->
                                                <a class="btn btn-success" href="{{ url('admin/test_stock_history/delete/'.$row['id']) }}">Bán</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>

    <!-- Cổ phiếu nắm giữ -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- /.col -->
                <div class="col-md-12">

                    @include('_message')
                    <!-- /.card -->

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title card-primary">Cổ phiếu nắm giữ thử nghiệm</h3>
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
                                    $conn = mysqli_connect("localhost", "root", "123456", "si");
                                    $sql_str = "
                            select *
                        from
                        (	select 
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
                                a.stock_company_fee_ratio,
                                (b.price_close*1000/a.avg_buy_price-1)*100 benifit_ratio
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
                        ) c
                        order by c.benifit_ratio desc;
                        ";
                                    $result = mysqli_query($conn, $sql_str);
                                    mysqli_close($conn);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?= $row['stock_code'] ?></td>
                                            <td><?= number_format($row['total_volume_in'], 0) ?></td>
                                            <td><?= number_format($row['avg_buy_price'], 0) ?></td>
                                            <td><?= number_format($row['total_buy_money'], 0) ?></td>
                                            <td><?= number_format($row['total_buy_fee'], 0) ?></td>
                                            <td><?= number_format($row['total_volume_out'], 0) ?></td>
                                            <td><?= number_format($row['avg_sell_price'], 0) ?></td>
                                            <td><?= number_format($row['total_sell_money'], 0) ?></td>
                                            <td><?= number_format($row['total_sell_fee'], 0) ?></td>
                                            <td><?= number_format(($row['total_sell_money'] - $row['total_sell_fee'] - $row['avg_buy_price'] * $row['total_volume_out'] * (1 + $row['stock_company_fee_ratio'] / 100)), 0); ?></td>
                                            <td><?= number_format((float)(($row['avg_sell_price'] / $row['avg_buy_price'] - 1) * 100), 2, '.', ''); ?>%</td>
                                            <td><?= number_format($row['stock_volume_remain'], 0) ?></td>
                                            <td><?= number_format($row['price_close'], 0) ?></td>
                                            <td><?= number_format($row['total_money_market_price'], 0) ?></td>
                                            <td><?= number_format($row['total_fee_market_price'], 0) ?></td>
                                            <td><?= number_format(($row['total_money_market_price'] - $row['total_fee_market_price'] - $row['avg_buy_price'] * $row['stock_volume_remain'] * (1 + $row['stock_company_fee_ratio'] / 100)), 0); ?></td>
                                            <td><?= number_format((float)(($row['price_close'] / $row['avg_buy_price'] - 1) * 100), 2, '.', ''); ?>%</td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Cổ phiếu đã bán -->
    <!--
    <section class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            @include('_message')

            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title card-primary">Cổ phiếu đã bán thử nghiệm</h3>
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
                    $conn = mysqli_connect("localhost", "root", "123456", "si");
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
                    $result = mysqli_query($conn, $sql_str);
                    mysqli_close($conn);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?= $row['stock_code'] ?></td>             
                                <td><?= $row['total_volume_in'] ?></td>
                                <td><?= number_format($row['avg_buy_price'], 0) ?></td>
                                <td><?= number_format($row['total_buy_money'], 0) ?></td>
                                <td><?= number_format($row['total_buy_fee'], 0) ?></td>
                                <td><?= $row['total_volume_out'] ?></td>
                                <td><?= number_format($row['avg_sell_price'], 0) ?></td>
                                <td><?= number_format($row['total_sell_money'], 0) ?></td>
                                <td><?= number_format($row['total_sell_fee'], 0) ?></td>
                                <td><?= number_format($row['total_sell_money'] - $row['total_sell_fee'] - $row['avg_buy_price'] * $row['total_volume_out'] * (1 + $row['stock_company_fee_ratio'] / 100), 0) ?></td>
                                <td><?= number_format(($row['avg_sell_price'] / $row['avg_buy_price'] - 1) * 100, 2) ?>%</td>
                            </tr>
                    <?php
                    }
                    ?>

                    </tbody>
                </table>
            </div>
            </div>
        </div>

        </div>
    </section>
    -->
</div>

@endsection