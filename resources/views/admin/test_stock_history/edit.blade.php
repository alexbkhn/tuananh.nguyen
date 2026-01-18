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
                      <label>Đã bán</label>                               
                      <select class="form-control" required id="is_sold" name="is_sold" placeholder="Đã bán">
                          <option {{ ($getRecord->is_sold == 1) ? 'selected' : '' }} value="1">Chưa bán</option>
                          <option {{ ($getRecord->is_sold == 2) ? 'selected' : '' }} value="2">Đã bán</option>
                      </select>
                    </div>
                  <div class="form-group">
                    <label>Loại giao dịch</label>                               
                    <select class="form-control" required id="transaction_type" name="transaction_type" placeholder="Loại giao dịch">
                        <option {{ ($getRecord->transaction_type == "Mua") ? 'selected' : '' }} value="Mua">Mua</option>
                        <option {{ ($getRecord->transaction_type == "Bán") ? 'selected' : '' }} value="Bán">Bán</option>
                    </select>
                  </div>

                  <div class="form-group">
                        <label>Công ty chứng khoán</label> 
                        <!--
                        <input type="text" class="form-control" id="stock_company" name="stock_company" value="{{ $getRecord->stock_company_code }}"
                            placeholder="Công ty chứng khoán">
                        -->
                      <select class="form-control" id="stock_company" name="stock_company" required>
                        <option value="{{ $getRecord->stock_company_code }}">{{ $getRecord->stock_company_code }}</option>
                        @foreach($getStockCompany as $stock_company_1)
                          <option value="{{ $stock_company_1->stock_company_code }}">{{ $stock_company_1->stock_company_code }}</option>
                        @endforeach          
                      </select>                              
                  </div>

                  <div class="form-group">
                        <label>Tỉ lệ phí giao dịch</label> 
                        <!--
                        <input type="text" class="form-control" id="stock_company" name="stock_company" value="{{ $getRecord->stock_company_code }}"
                            placeholder="Công ty chứng khoán">
                        -->
                      <select class="form-control" id="stock_company_fee_ratio" name="stock_company_fee_ratio" required>
                        <option value="{{ $getRecord->stock_company_fee_ratio }}">{{ $getRecord->stock_company_fee_ratio }}</option>
                        @foreach($getStockCompany as $stock_company_1)
                          <option value="{{ $stock_company_1->stock_company_fee_ratio }}">{{ $stock_company_1->stock_company_code }}</option>
                        @endforeach          
                      </select>                              
                  </div>

                  <div class="form-group">
                      <label>Mã chứng khoán</label> 
                      <input type="text" class="form-control" id="stock_code" name="stock_code" value="{{ $getRecord->stock_code }}"
                          placeholder="Mã chứng khoán">
                  </div>

                  <div class="form-group">
                    <label>Khối lượng mua</label> 
                      <input type="int" class="form-control" id="stock_volume" name="stock_volume" value="{{ $getRecord->stock_volume }}"
                          placeholder="Số lượng">
                  </div>
                  <div class="form-group">
                    <label>Giá mua</label> 
                      <input type="float" class="form-control" id="stock_price" name="stock_price" value="{{ $getRecord->stock_price }}"
                          placeholder="Giá mua">
                  </div>   

                  <div class="form-group">
                  <!--
                      <input type="date" class="form-control" id="stock_date" name="stock_date"
                          placeholder="Thời gian">
                  -->
                    <label>Thời gian giao dịch</label> 
                      <input 
                              placeholder="Thời gian giao dịch"
                              value="{{ $getRecord->stock_date }}"
                              class="form-control" 
                              type="text" 
                              onfocus="(this.type='date')"
                              onblur="(this.type='text')"
                              id="stock_date" 
                              name="stock_date"
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