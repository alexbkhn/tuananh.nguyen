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
                    <label>Loại giao dịch</label>                               
                    <select class="form-control" required id="transaction_type" name="transaction_type" placeholder="Loại giao dịch">
                        <option {{ ($getRecord->transaction_type == "Nạp") ? 'selected' : '' }} value="Nạp">Nạp</option>
                        <option {{ ($getRecord->transaction_type == "Rút") ? 'selected' : '' }} value="Rút">Rút</option>
                        <option {{ ($getRecord->transaction_type == "Lãi") ? 'selected' : '' }} value="Lãi">Lãi</option>
                        <option {{ ($getRecord->transaction_type == "Phí") ? 'selected' : '' }} value="Phí">Phí</option>
                    </select>
                  </div>

                  <div class="form-group">
                        <!-- <label class="form-label">Công ty chứng khoán</label>                                      
                            <select class="form-control" name="stock_company">
                            <option value="" disabled selected>Công ty chứng khoán</option>
                            </select>          
                        --> 
                        <label>Công ty chứng khoán</label> 
                        <input type="text" class="form-control" id="stock_company_code" name="stock_company_code" value="{{ $getRecord->stock_company_code }}"
                          placeholder="Công ty chứng khoán">
                  </div>

                  <div class="form-group">
                      <label>Note</label> 
                      <input type="text" class="form-control" id="note" name="note" value="{{ $getRecord->note }}"
                          placeholder="Note">
                  </div>

                  <div class="form-group">
                    <label>Số tiền</label> 
                    <input type="float" class="form-control" id="total_money" name="total_money" value="{{ $getRecord->total_money }}"
                          placeholder="Số tiền">
                  </div>
                  <div class="form-group">
                    <label>Phí</label> 
                    <input type="float" class="form-control" id="total_fee" name="total_fee" value="{{ $getRecord->total_fee }}"
                    placeholder="Phí">
                  </div>   

                  <div class="form-group">
                  <!--
                      <input type="date" class="form-control" id="stock_date" name="stock_date"
                          placeholder="Thời gian">
                  -->
                    <label>Thời gian giao dịch</label> 
                      <input 
                              placeholder="Thời gian giao dịch"
                              value="{{ $getRecord->nav_date }}"
                              class="form-control" 
                              type="text" 
                              onfocus="(this.type='date')"
                              onblur="(this.type='text')"
                              id="nav_date" 
                              name="nav_date"
                      /> 
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