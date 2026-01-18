@extends('layouts.app')

@section('content')
    

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lịch sử giao dịch</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
            <a href="{{ url('admin/stock/stock_history') }}" class="btn btn-primary"> Add new</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
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
                <h3 class="card-title">Thêm mới giao dịch</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="form-group row"> </div>
                <div class="form-group row">
                  <div class="col-sm-2 mb-3 mb-sm-0">                                 
                      <select class="form-control" required id="transaction_type" name="transaction_type" placeholder="Loại giao dịch">
                          <option value="" disabled selected>Loại giao dịch</option>
                          <option value="Mua">Mua</option>
                          <option value="Bán">Bán</option>
                      </select>
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <!-- <label class="form-label">Công ty chứng khoán</label>                                      
                          <select class="form-control" name="stock_company">
                          <option value="" disabled selected>Công ty chứng khoán</option>
                          </select>          
                      --> 
                      <input type="text" class="form-control" id="stock_company" name="stock_company"
                          placeholder="Công ty chứng khoán">
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <input type="text" class="form-control" id="stock_code" name="stock_code"
                          placeholder="Mã chứng khoán">
                  </div>
                  <div class="col-sm-1">
                      <input type="int" class="form-control" id="stock_volume" name="stock_volume"
                          placeholder="Số lượng">
                  </div>
                  <div class="col-sm-1">
                      <input type="float" class="form-control" id="stock_price" name="stock_price"
                          placeholder="Giá">
                  </div>                                
                  <div class="col-sm-2 mb-3 mb-sm-0">
                  <!--
                      <input type="date" class="form-control" id="stock_date" name="stock_date"
                          placeholder="Thời gian">
                  -->
                      <input 
                              placeholder="Thời gian giao dịch"
                              class="form-control" 
                              type="text" 
                              onfocus="(this.type='date')"
                              onblur="(this.type='text')"
                              id="stock_date" 
                              name="stock_date"
                      /> 
                  </div>

                  <button class="btn btn-primary">Tạo mới</button>
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

            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title card-primary">Thông tin giao dịch</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Loại giao dịch</th>
                      <th>Mã chứng khoán</th>
                      <th>Giá mua</th>
                      <th>Khối lượng mua</th>
                      <th>Thời gian mua</th>
                      <th>Công ty chứng khoán</th>
                      <th>Tổng tiền mua</th>
                      <th>Phí mua</th>
                      <th>Đã bán</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                    <tr>
                      <td>{{ $value->transaction_type }}</td>
                      <td>{{ $value->stock_code }}</td>
                      <td>{{ $value->stock_price }}</td>
                      <td>{{ $value->stock_volume }}</td>
                      <td>{{ $value->stock_date }}</td>
                      <td>{{ $value->stock_company_code }}</td>
                      <td>{{ $value->total_money }}</td>
                      <td>{{ $value->total_fee }}</td>
                      <td>{{ $value->is_sold }}</td>
                      <td>
                        <a href="{{ url('admin/admin/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ url('admin/admin/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
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