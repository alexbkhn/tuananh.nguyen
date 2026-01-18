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
          <!-- /.container-fluid 
          <div class="col-sm-6" style="text-align: right;">
            <a href="{{ url('admin/stock_history/add') }}" class="btn btn-primary"> Thêm mới </a>
          </div>
          -->
        </div>
      </div>
    </section>

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
                <h3 class="card-title card-primary">Thông tin giao dịch</h3>
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
                      
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <label>Mã chứng khoán</label>    
                      <input type="text" class="form-control" id="s_stock_code" name="s_stock_code"
                          placeholder="Mã chứng khoán">
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
                        <a href="{{ url('admin/stock_history/list') }}" class="btn btn-success" style="margin-top: 30px; margin-left: 5px;">Reset</a>
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
                      <td>{{ $value->price_close }}</td>
                      <td>{{ $value->stock_code }}</td>                      
                      <td>{{ $value->stock_volume_remain }}</td>
                      <td>{{ $value->total_volume_in }}</td>
                      <td>{{ $value->avg_buy_price }}</td>
                      <td>{{ $value->total_buy_money }}</td>
                      <td>{{ $value->total_buy_fee }}</td>
                      <td>{{ $value->total_volume_out }}</td>
                      <td>{{ $value->avg_sell_price }}</td>
                      <td>
                        {{ $value->total_sell_money }}
                      </td>
                      <td>
                        <a href="{{ url('admin/stock_history/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ url('admin/stock_history/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
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