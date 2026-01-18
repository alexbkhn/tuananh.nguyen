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
                        <!-- <label class="form-label">Công ty chứng khoán</label>                                      
                            <select class="form-control" name="stock_company">
                            <option value="" disabled selected>Công ty chứng khoán</option>
                            </select>          
                        --> 
                        <label>Tên công ty chứng khoán</label> 
                        <input type="text" class="form-control" id="stock_company" name="stock_company" value="{{ $getRecord->stock_company }}"
                            placeholder="Công ty chứng khoán">
                  </div>

                  <div class="form-group">
                        <label>Mã công ty chứng khoán</label> 
                        <input type="text" class="form-control" id="stock_company_code" name="stock_company_code" value="{{ $getRecord->stock_company_code }}"
                            placeholder="Công ty chứng khoán">
                  </div>

                  <div class="form-group">
                    <label>Giá mua</label> 
                      <input type="float" class="form-control" id="stock_company_fee_ratio" name="stock_company_fee_ratio" value="{{ $getRecord->stock_company_fee_ratio }}"
                          placeholder="Phí giao dịch (%)">
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