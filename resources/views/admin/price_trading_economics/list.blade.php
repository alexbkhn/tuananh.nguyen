@extends('layouts.app')

@section('content')
    

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="https://tradingeconomics.com/united-states/currency" target="_blank" class="nav-link"> Giá hàng hóa thế giới: Trading Economics </a>
          </div>
        </div>
      </div>
    </section>

  <iframe src="https://tradingeconomics.com/commodity/rubber" width="100%" height="800" style="border:none;"
      title="Giá hàng hóa tradingeconomics.com">
      frameborder="0"
  </iframe>
</div>
@endsection