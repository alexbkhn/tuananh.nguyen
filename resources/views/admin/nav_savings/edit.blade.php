@extends('layouts.app')

@section('content')
    

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cập nhật giao dịch</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- THÊM MỚI GIAO DỊCH -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cập nhật giao dịch</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body"> 

                  <div class="form-group">
                        <label>Ngân hàng</label> 
                        <input type="text" class="form-control" id="bank_code" name="bank_code" value="{{ $getRecord->bank_code }}"
                          placeholder="Ngân hàng">
                  </div>

                  <div class="form-group">
                      <label>Tổng tiền gửi</label> 
                      <input type="float" class="form-control" id="money_saving" name="money_saving" value="{{ $getRecord->money_saving }}"
                          placeholder="Tổng tiền gửi">
                  </div>

                  <div class="form-group">
                      <label>Lãi suất</label> 
                      <input type="float" class="form-control" id="deposit_rate" name="deposit_rate" value="{{ $getRecord->deposit_rate }}"
                          placeholder="Lãi suất">
                  </div>

                  <div class="form-group">
                    <label>Thời gian bắt đầu</label> 
                      <input 
                              placeholder="Thời gian bắt đầu"
                              value="{{ $getRecord->start_time }}"
                              class="form-control" 
                              type="text" 
                              onfocus="(this.type='date')"
                              onblur="(this.type='text')"
                              id="start_time" 
                              name="start_time"
                      /> 
                  </div>

                  <div class="form-group">
                    <label>Thời gian kết thúc</label> 
                      <input 
                              placeholder="Thời gian kết thúc"
                              value="{{ $getRecord->end_time }}"
                              class="form-control" 
                              type="text" 
                              onfocus="(this.type='date')"
                              onblur="(this.type='text')"
                              id="end_time" 
                              name="end_time"
                      /> 
                  </div>

                  <div class="form-group">
                        <label>Note</label> 
                        <input type="text" class="form-control" id="note" name="note" value="{{ $getRecord->note }}"
                          placeholder="Note">
                  </div>

                  <div class="form-group">
                    <button class="btn btn-primary">Update</button>
                  </div>
                </div>
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
     
  </div>

@endsection