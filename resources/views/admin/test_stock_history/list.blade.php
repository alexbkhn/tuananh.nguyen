@extends('layouts.app')

@section('content')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lịch sử giao dịch thử nghiệm</h1>
        </div>
        <!-- /.container-fluid 
          <div class="col-sm-6" style="text-align: right;">
            <a href="{{ url('admin/test_stock_history/add') }}" class="btn btn-primary"> Thêm mới </a>
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
                <!--
                  <div class="col-sm-1 mb-3 mb-sm-0">
                      <input type="float" class="form-control" id="stock_company_fee_ratio" name="stock_company_fee_ratio"
                          placeholder="Phí giao dịch">     
                  </div>
                -->
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
                  <!--
                      <input type="date" class="form-control" id="stock_date" name="stock_date"
                          placeholder="Thời gian">
                  -->
                  <input placeholder="Thời gian giao dịch" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="stock_date" name="stock_date" required />
                </div>
                <button class="btn btn-primary">Tạo mới</button> <!--style="margin-left: 150px;"..-->
              </div>
            </form>
          </div>
          <!-- /.card -->

        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <!-- Thông tin giao dịch -->
  <section class="content">



    <div class="container-fluid">
      <div class="row">

        <!-- /.col -->
        <div class="col-md-12">

          @include('_message')
          <!-- /.card -->

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title card-primary">Thông tin giao dịch thử nghiệm (Tổng: {{ $getRecord->total() }})</h3>
            </div>

            <!-- Tìm kiếm -->
            <form method="get" action="">
              <div class="form-group row"> </div>
              <div class="form-group row">
                <div class="col-sm-2 mb-3 mb-sm-0" style="margin-left: 25px;">
                  <label>Loại giao dịch</label>
                  <select class="form-control" id="s_transaction_type" name="s_transaction_type" placeholder="Loại giao dịch">
                    <option value="">Loại giao dịch</option>
                    <option value="Mua">Mua</option>
                    <option value="Bán">Bán</option>
                  </select>
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <label>Công ty chứng khoán</label>
                  <!-- 
                      <input type="text" class="form-control" id="s_stock_company" name="s_stock_company"
                          placeholder="Công ty chứng khoán">
                      -->
                  <select class="form-control" id="s_stock_company" name="s_stock_company">
                    <option value="" disabled selected>Công ty chứng khoán</option>
                    @foreach($getStockCompany as $stock_company_1)
                    <option value="{{ $stock_company_1->stock_company_code }}">{{ $stock_company_1->stock_company_code }}</option>
                    @endforeach
                  </select>

                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <label>Mã chứng khoán</label>
                  <input type="text" class="form-control" id="s_stock_code" name="s_stock_code" placeholder="Mã chứng khoán">
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <label>Thời gian giao dịch</label>
                  <input type="date" placeholder="Thời gian giao dịch" class="form-control" id="s_stock_date" name="s_stock_date">
                </div>
                <div class="col-sm-1 mb-3 mb-sm-0">
                  <label>Trạng thái</label>
                  <select class="form-control" id="s_is_sold" name="s_is_sold">
                    <option value="" disabled selected>Trạng thái</option>
                    <option value="1">Chưa bán</option>
                    <option value="2">Đã bán</option>
                  </select>
                </div>
                <button class="btn btn-primary" type="Submit" style="margin-top: 30px;">Search</button> <!--  margin-left: 230px; -->
                <a></a>
                <a href="{{ url('admin/test_stock_history/list') }}" class="btn btn-success" style="margin-top: 30px; margin-left: 5px;">Reset</a>
              </div>
            </form>
            <!-- Tìm kiếm -->

            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Thời gian mua</th>
                    <th>Công ty chứng khoán</th>
                    <th>Loại giao dịch</th>
                    <th>Mã chứng khoán</th>
                    <th>Giá mua</th>
                    <th>Khối lượng mua</th>
                    <th>Tổng tiền mua</th>
                    <th>Phí mua</th>
                    <th>Tỉ lệ thuế/phí (%)</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($getRecord as $value)
                  <tr>
                    <td>{{ date('d-m-Y', strtotime($value->stock_date)) }}</td>
                    <td>{{ $value->stock_company_code }}</td>
                    <td>{{ $value->transaction_type }}</td>
                    <td>{{ $value->stock_code }}</td>
                    <td><?= number_format($value->stock_price, 2) ?></td>
                    <td>{{ $value->stock_volume }}</td>
                    <td><?= number_format($value->total_money, 0) ?></td>
                    <td><?= number_format($value->total_fee, 2) ?></td>
                    <td>{{ $value->stock_company_fee_ratio }}</td>
                    <td>
                      @if($value->is_sold == 1)
                      Chưa bán
                      @else
                      Đã bán
                      @endif
                    </td>
                    <td>
                      <a href="{{ url('admin/test_stock_history/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                      <a href="{{ url('admin/test_stock_history/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div style="padding: 10px; text-align: right;">
                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection