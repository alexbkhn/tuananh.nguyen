@extends('layouts.app')

@section('content')
    

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tiền gửi tiết kiệm</h1>
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
                  <div class="col-sm-1 mb-3 mb-sm-0" style="margin-left: 25px;">                                 
                      <input type="text" class="form-control" id="bank_code" name="bank_code"
                          placeholder="Ngân hàng">
                  </div>
                  <div class="col-sm-1">
                      <input type="float" class="form-control" id="money_saving" name="money_saving"
                          placeholder="Tổng tiền gửi">
                  </div> 
                  <div class="col-sm-1">
                      <input type="float" class="form-control" id="deposit_rate" name="deposit_rate"
                          placeholder="Lãi suất">
                  </div> 
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <input 
                              placeholder="Thời gian bắt đầu"
                              class="form-control" 
                              type="text" 
                              onfocus="(this.type='date')"
                              onblur="(this.type='text')"
                              id="start_time" 
                              name="start_time"
                      /> 
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <input 
                              placeholder="Thời gian kết thúc"
                              class="form-control" 
                              type="text" 
                              onfocus="(this.type='date')"
                              onblur="(this.type='text')"
                              id="end_time" 
                              name="end_time"
                      /> 
                  </div>
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <input type="text" class="form-control" id="note" name="note"
                          placeholder="Note">
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
                  <div class="col-sm-1 mb-3 mb-sm-0" style="margin-left: 25px;">   
                    <label>Ngân hàng</label>                                  
                    <input type="text" class="form-control" id="s_bank_code" name="s_bank_code"
                          placeholder="Ngân hàng">
                  </div>
                  <div class="col-sm-1">
                    <label>Tổng tiền gửi</label>       
                      <input type="float" class="form-control" id="s_money_saving" name="s_money_saving"
                          placeholder="Tổng tiền gửi">
                  </div> 
                  <div class="col-sm-1">
                    <label>Lãi suất (%)</label>  
                      <input type="float" class="form-control" id="s_deposit_rate" name="s_deposit_rate"
                          placeholder="Lãi suất">
                  </div> 
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <label>Thời gian bắt đầu</label>    
                      <input type="date" placeholder="Thời gian bắt đầu" class="form-control" id="s_start_time" name="s_start_time">
                  </div>                    
                  <div class="col-sm-2 mb-3 mb-sm-0">
                      <label>Thời gian kết thúc</label>    
                      <input type="date" placeholder="Thời gian giao dịch" class="form-control" id="s_end_time" name="s_end_time">
                  </div>  
                  <div class="col-sm-2 mb-3 mb-sm-0">
                    <label>Note</label>  
                      <input type="text" class="form-control" id="s_note" name="s_note"
                          placeholder="Note">
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
                      <th>Ngân hàng</th>
                      <th>Tổng tiền gửi</th>
                      <th>Tổng tiền lãi</th>           
                      <th>Lãi suất (%)</th>
                      <th>Thời gian bắt đầu</th>
                      <th>Thời gian kết thúc</th>
                      <th>Note</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                    <tr>                    
                      <td>{{ $value->bank_code }}</td>                      
                      <td><?=number_format($value->money_saving,0)?></td>
                      <td><?=number_format($value->money_deposit,0)?></td>
                      <td><?=number_format($value->deposit_rate,2)?></td>
                      <td>{{ date('d-m-Y', strtotime($value->start_time)) }}</td>
                      <td>{{ date('d-m-Y', strtotime($value->end_time)) }}</td>
                      <td>{{ $value->note }}</td>
                      <td>
                        <a href="{{ url('admin/nav_savings/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ url('admin/nav_savings/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
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