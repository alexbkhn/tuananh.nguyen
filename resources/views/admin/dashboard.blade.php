@extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      @if(isset($error))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> {{ $error }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif

      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-3"><i class="fas fa-money-bill"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tiền Tiết Kiệm</span>
              <span class="info-box-number">{{ number_format($r_in1, 0, ',', '.') }} ₫</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-3"><i class="fas fa-coins"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tiền Đầu Tư Cổ Phiếu</span>
              <span class="info-box-number">{{ number_format($tong_tien_mua, 0, ',', '.') }} ₫</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-3"><i class="fas fa-chart-pie"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tiền Bán Cổ Phiếu</span>
              <span class="info-box-number">{{ number_format($tong_tien_ban, 0, ',', '.') }} ₫</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-3"><i class="fas fa-chart-line"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Phí Giao Dịch</span>
              <span class="info-box-number">{{ number_format($tong_phí, 0, ',', '.') }} ₫</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Tóm Tắt Tài Chính</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <table class="table table-bordered">
                    <tr>
                      <td><strong>Tiền Tiết Kiệm Nạp Vào:</strong></td>
                      <td class="text-right">{{ number_format($r_in1, 0, ',', '.') }} ₫</td>
                    </tr>
                    <tr>
                      <td><strong>Tiền Tiết Kiệm Rút Ra:</strong></td>
                      <td class="text-right">{{ number_format($r_out1, 0, ',', '.') }} ₫</td>
                    </tr>
                    <tr class="bg-light">
                      <td><strong>Tiền Tiết Kiệm Còn Lại:</strong></td>
                      <td class="text-right"><strong>{{ number_format($tien_con_lai, 0, ',', '.') }} ₫</strong></td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table table-bordered">
                    <tr>
                      <td><strong>Tổng Tiền Mua Cổ Phiếu:</strong></td>
                      <td class="text-right">{{ number_format($tong_tien_mua, 0, ',', '.') }} ₫</td>
                    </tr>
                    <tr>
                      <td><strong>Tổng Tiền Bán Cổ Phiếu:</strong></td>
                      <td class="text-right">{{ number_format($tong_tien_ban, 0, ',', '.') }} ₫</td>
                    </tr>
                    <tr class="bg-light">
                      <td><strong>Giá Trị Danh Mục Hiện Tại:</strong></td>
                      <td class="text-right"><strong>{{ number_format($gia_tri_dau_tu, 0, ',', '.') }} ₫</strong></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>

    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection
