@extends('layouts.app')

@section('content')

<!-- Kết quả thực hiện

<?php
$conn = mysqli_connect("localhost", "root", "123456", "si");
//Tiền nạp
$sql_str = "SELECT sum(total_money) as r_in FROM si.stock_nav WHERE transaction_type = 'Nạp' and is_delete = 0";
$result = mysqli_query($conn, $sql_str);
$res = mysqli_query($conn, $sql_str);
$r_in = mysqli_fetch_assoc($res);
$r_in1 = $r_in['r_in'];
//Tiền rút
$sql_str = "SELECT sum(total_money) as r_out FROM si.stock_nav WHERE transaction_type = 'Rút' and is_delete = 0";
$result = mysqli_query($conn, $sql_str);
$res = mysqli_query($conn, $sql_str);
$r_out = mysqli_fetch_assoc($res);
$r_out1 = $r_out['r_out'];
//Tiền lãi
$sql_str = "SELECT sum(total_money) as r_out FROM si.stock_nav WHERE transaction_type = 'Lãi' and is_delete = 0";
$result = mysqli_query($conn, $sql_str);
$res = mysqli_query($conn, $sql_str);
$tong_tien_cong_them1 = mysqli_fetch_assoc($res);
$tong_tien_cong_them = $tong_tien_cong_them1['r_out'];
//Tiền phí
$sql_str = "SELECT sum(total_money) as r_out FROM si.stock_nav WHERE transaction_type = 'Phí' and is_delete = 0";
$result = mysqli_query($conn, $sql_str);
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
                and is_delete = 0
                group by sh.stock_code
            ) shb on sh.stock_code = shb.stock_code
            where sh.transaction_type = 'Mua'
            and is_delete = 0
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
$result = mysqli_query($conn, $sql_str);
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
                and is_delete = 0
                group by sh.stock_code
            ) shb on sh.stock_code = shb.stock_code
            where sh.transaction_type = 'Mua'
            and is_delete = 0
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
$result = mysqli_query($conn, $sql_str);
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
                and is_delete = 0
                group by sh.stock_code
            ) shb on sh.stock_code = shb.stock_code
            where sh.transaction_type = 'Mua'
            and is_delete = 0
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
$result = mysqli_query($conn, $sql_str);
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
                and is_delete = 0
                group by sh.stock_code
            ) shb on sh.stock_code = shb.stock_code
            where sh.transaction_type = 'Mua'
            and is_delete = 0
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
$result = mysqli_query($conn, $sql_str);
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
                and is_delete = 0
                group by sh.stock_code
            ) shb on sh.stock_code = shb.stock_code
            where sh.transaction_type = 'Mua'
            and is_delete = 0
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
$result = mysqli_query($conn, $sql_str);
$res = mysqli_query($conn, $sql_str);
$tong_tien_ban_cp = mysqli_fetch_assoc($res);
$tong_tien_ban = $tong_tien_ban_cp['r_out'];
//Tổng phí mua
$sql_str = "select
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
            and is_delete = 0
            group by sh.stock_code
        ) shb on sh.stock_code = shb.stock_code
        where sh.transaction_type = 'Mua'
        and is_delete = 0
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
$result = mysqli_query($conn, $sql_str);
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
            and is_delete = 0
            group by sh.stock_code
        ) shb on sh.stock_code = shb.stock_code
        where sh.transaction_type = 'Mua'
        and is_delete = 0
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
$result = mysqli_query($conn, $sql_str);
$res = mysqli_query($conn, $sql_str);
$tong_phi_ban_cp = mysqli_fetch_assoc($res);
$tong_phi_ban = $tong_phi_ban_cp['r_out'];
//Tiền mặt khả dụng
$tien_du_tkck = $r_nav - $tong_tien_mua - $tong_phi_mua + $tong_tien_ban - $tong_phi_ban + $tong_tien_cong_them - $tong_tien_tru_phi;
mysqli_close($conn);

?>

Kết thúc kết quả thực hiện -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo number_format($r_nav, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tổng vốn</p>
              <h3><?php echo number_format($tien_du_tkck, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tiền mặt khả dụng</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ url('admin/nav_history/list') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo number_format($r_nav_in_stock, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tiền trong cổ phiếu tồn</p>
              <h3><?php echo number_format($tong_tien_ban_gia_thi_truong, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Giắ trị cổ phiếu theo thị trường</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{ url('admin/stock_keeping/list') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo number_format($tong_tien_mua, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tổng tiền mua</p>
              <h3><?php echo number_format($tong_phi_mua, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tổng phí mua</p>
            </div>
            <div class="icon">
              <i class="ion ion-arrow-graph-up-right"></i>
            </div>
            <a href="{{ url('admin/stock_keeping/list') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?php echo number_format($tong_tien_ban, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tổng tiền bán</p>
              <h3><?php echo number_format($tong_phi_ban, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tổng phí bán</p>
            </div>
            <div class="icon">
              <i class="ion ion-arrow-graph-up-left"></i>
            </div>
            <a href="{{ url('admin/stock_keeping/list') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-gradient-primary">
            <div class="inner">
              <h3><?php echo number_format($tong_tien_cong_them, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tổng tiền cộng khác</p>
              <h3><?php echo number_format($tong_tien_tru_phi, 0); ?> <sup style="font-size: 20px">VNĐ</sup></h3>
              <p>Tổng tiền trừ khác</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/stock_keeping/list') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

          <!-- TO DO List -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                To Do List
              </h3>

              <div class="card-tools">
                <ul class="pagination pagination-sm">
                  <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                  <li class="page-item"><a href="#" class="page-link">1</a></li>
                  <li class="page-item"><a href="#" class="page-link">2</a></li>
                  <li class="page-item"><a href="#" class="page-link">3</a></li>
                  <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <!-- /.card-header TO DO LIST-->
            <div class="card-body">
              <?php
              $conn = mysqli_connect("localhost", "root", "123456", "si");
              $sql_str = "
                    SELECT 
                      ntd.id,
                      ntd.work,
                      ntd.detail, 
                      ntd.priority,
                      ntd.deadline,
                      ntd.state,
                      ntd.created_at
                    FROM
                      si.note_to_do ntd
                    WHERE
                      ntd.is_delete = 0;
                  ";

              $result = mysqli_query($conn, $sql_str);
              mysqli_close($conn);
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <ul class="todo-list" data-widget="todo-list">
                  <li>
                    <!-- drag handle -->
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="<?= $row['id'] ?>" id="<?= $row['id'] ?>">
                      <label for="<?= $row['id'] ?>"></label>
                    </div>
                    <!-- todo text -->
                    
                    <span class="text"><?= $row['work'] ?></span>
                    <span><?= $row['detail'] ?></span>
                    <!-- Emphasis label -->
                    <small class="badge badge-danger"><i class="far fa-clock"></i><?= $row['deadline'] ?></small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                      <a href="{{ url('admin/note_to_do/list') }}" class="fas fa-edit"></a>
                      <!-- <i class="fas fa-trash-o"></i> -->
                    </div>
                  </li>
                </ul>
              <?php
              }
              ?>
            </div>




            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
            </div>
          </div>
          <!-- /.card TO DO LIST-->

          <!-- Đồ thị vnindex -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                VNindex
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div><!-- /.card-header -->
            <div class="card-body">
              @include('chart.chart-nen-vnindex')
            </div><!-- /.card-body -->
          </div>
          <!-- /.Đồ thị vnindex -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Sales
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>
                </ul>
              </div>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                  <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                  <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map card -->
          <div class="card bg-gradient-primary">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-map-marker-alt mr-1"></i>
                Visitors
              </h3>
              <!-- card tools -->
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <div class="card-body">
              <div id="world-map" style="height: 250px; width: 100%;"></div>
            </div>
            <!-- /.card-body-->
            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <div id="sparkline-1"></div>
                  <div class="text-white">Visitors</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-2"></div>
                  <div class="text-white">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="text-white">Sales</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.card -->

          <!-- solid sales graph -->
          <div class="card bg-gradient-info">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Sales Graph
              </h3>

              <div class="card-tools">
                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card -->

          <!-- Calendar -->
          <div class="card bg-gradient-success">
            <div class="card-header border-0">

              <h3 class="card-title">
                <i class="far fa-calendar-alt"></i>
                Calendar
              </h3>
              <!-- tools card -->
              <div class="card-tools">
                <!-- button with a dropdown -->
                <div class="btn-group">
                  <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" role="menu">
                    <a href="#" class="dropdown-item">Add new event</a>
                    <a href="#" class="dropdown-item">Clear events</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">View calendar</a>
                  </div>
                </div>
                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <!--
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                  -->
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body pt-0">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection