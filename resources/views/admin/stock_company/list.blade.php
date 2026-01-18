@extends('layouts.app')

@section('content')
    

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ứng dụng giao dịch chứng khoán</h1>
          </div>
          <!-- /.container-fluid 
          <div class="col-sm-6" style="text-align: right;">
            <a href="{{ url('admin/stock_company/add') }}" class="btn btn-primary"> Thêm mới </a>
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
                <h3 class="card-title">Thêm mới</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="form-group row"> </div>
                <div class="form-group row">
                  <div class="col-sm-2 mb-3 mb-sm-0" style="margin-left: 25px;">
                      <input type="text" class="form-control" id="stock_company" name="stock_company"
                          placeholder="Tên công ty chứng khoán">
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <input type="text" class="form-control" id="stock_company_code" name="stock_company_code"
                          placeholder="Mã công ty chứng khoán">
                  </div>
                  <div class="col-sm-1">
                      <input type="float" class="form-control" id="stock_company_fee_ratio" name="stock_company_fee_ratio"
                          placeholder="Phí giao dịch">
                  </div>                                
                    <button class="btn btn-primary" style="margin-left: 150px;">Tạo mới</button>
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
                <h3 class="card-title card-primary">Thông tin chi tiết (Tổng: {{ $getRecord->total() }})</h3>
              </div>

<!-- Tìm kiếm -->
              <form method="get" action="">
                <div class="form-group row"> </div>
                <div class="form-group row">
                  <div class="col-sm-2 mb-3 mb-sm-0" style="margin-left: 25px;">
                      <!-- <label class="form-label">Công ty chứng khoán</label>                                      
                          <select class="form-control" name="stock_company">
                          <option value="" disabled selected>Công ty chứng khoán</option>
                          </select>          
                      --> 
                      <label>Công ty chứng khoán</label>    
                      <input type="text" class="form-control" id="s_stock_company" name="s_stock_company"
                          placeholder="Tên công ty chứng khoán">
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <label>Mã chứng khoán</label>    
                      <input type="text" class="form-control" id="s_stock_company_code" name="s_stock_company_code"
                          placeholder="Mã công ty chứng khoán">
                  </div>            
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <label>Thời gian giao dịch</label>    
                      <input type="float" placeholder="Phí giao dịch" class="form-control" id="s_stock_company_fee_ratio" name="s_stock_company_fee_ratio">
                  </div>                
                        <button class="btn btn-primary" type="Submit" style="margin-top: 30px; margin-left: 230px;">Search</button>
                        <a></a>
                        <a href="{{ url('admin/stock_company/list') }}" class="btn btn-success" style="margin-top: 30px; margin-left: 5px;">Reset</a>
                      </div>
              </form>
<!-- Tìm kiếm -->

              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Tên công ty chứng khoán</th>
                      <th>Mã công ty chứng khoán</th>
                      <th>Phí giao dịch</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                    <tr>
                      <td>{{ $value->stock_company }}</td>
                      <td>{{ $value->stock_company_code }}</td>                      
                      <td>{{ $value->stock_company_fee_ratio }}</td>
                      <td>
                        <a href="{{ url('admin/stock_company/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ url('admin/stock_company/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
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