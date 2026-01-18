@extends('layouts.app')

@section('content')
    

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lịch sử vốn</h1>
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
                <h3 class="card-title">Thêm mới giao dịch</h3>
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
                          <option value="Nạp">Nạp</option>
                          <option value="Rút">Rút</option>
                          <option value="Lãi">Lãi</option>
                          <option value="Phí">Phí</option>
                      </select>
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <!-- <label class="form-label">Công ty chứng khoán</label>                                      
                          <select class="form-control" name="stock_company">
                          <option value="" disabled selected>Công ty chứng khoán</option>
                          </select>          
                      --> 
                      <input type="text" class="form-control" id="stock_company_code" name="stock_company_code"
                          placeholder="Công ty chứng khoán">
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <input type="text" class="form-control" id="note" name="note"
                          placeholder="Note">
                  </div>
                  <div class="col-sm-1">
                      <input type="float" class="form-control" id="total_money" name="total_money"
                          placeholder="Số tiền">
                  </div>  
                  <div class="col-sm-1">
                      <input type="float" class="form-control" id="total_fee" name="total_fee"
                          placeholder="Phí">
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
                              id="nav_date" 
                              name="nav_date"
                      /> 
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
                <h3 class="card-title card-primary">Thông tin giao dịch (Tổng: {{ $getRecord->total() }})</h3>
              </div>

<!-- Tìm kiếm -->
              <form method="get" action="">
                <div class="form-group row"> </div>
                <div class="form-group row">
                  <div class="col-sm-2 mb-3 mb-sm-0" style="margin-left: 25px;">      
                      <label>Loại giao dịch</label>                           
                      <select class="form-control" id="s_transaction_type" name="s_transaction_type" placeholder="Loại giao dịch">
                          <option value="">Loại giao dịch</option>
                          <option value="Nạp">Nạp</option>
                          <option value="Rút">Rút</option>
                          <option value="Lãi">Lãi</option>
                          <option value="Phí">Phí</option>
                      </select>
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <!-- <label class="form-label">Công ty chứng khoán</label>                                      
                          <select class="form-control" name="stock_company">
                          <option value="" disabled selected>Công ty chứng khoán</option>
                          </select>          
                      --> 
                      <label>Công ty chứng khoán</label>    
                      <input type="text" class="form-control" id="s_stock_company_code" name="s_stock_company_code"
                          placeholder="Công ty chứng khoán">
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <label>Note</label>    
                      <input type="text" class="form-control" id="s_note" name="s_note"
                          placeholder="Note">
                  </div>            
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <label>Thời gian giao dịch</label>    
                      <input type="date" placeholder="Thời gian giao dịch" class="form-control" id="s_nav_date" name="s_nav_date">
                  </div>                
                        <button class="btn btn-primary" type="Submit" style="margin-top: 30px; margin-left: 230px;">Search</button>
                        <a></a>
                        <a href="{{ url('admin/nav_history/list') }}" class="btn btn-success" style="margin-top: 30px; margin-left: 5px;">Reset</a>
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
                      <th>Tổng tiền</th>
                      <th>Phí</th>
                      <th>Note</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                    <tr>
                      <td>{{ date('d-m-Y', strtotime($value->nav_date)) }}</td>
                      <td>{{ $value->stock_company_code }}</td>                      
                      <td>{{ $value->transaction_type }}</td>
                      <td><?=number_format($value->total_money,0)?></td>
                      <td>{{ $value->total_fee }}</td>
                      <td>{{ $value->note }}</td>
                      <td>
                        <a href="{{ url('admin/nav_history/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ url('admin/nav_history/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
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