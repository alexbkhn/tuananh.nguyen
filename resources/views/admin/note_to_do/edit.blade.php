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
                  <label>Độ ưu tiên</label>
                  <input type="text" class="form-control" id="priority" name="priority" value="{{ $getRecord->priority }}" placeholder="Độ ưu tiên">
                </div>

                <div class="form-group">
                  <label>Công việc</label>
                  <input type="text" class="form-control" id="work" name="work" value="{{ $getRecord->work }}" placeholder="Công việc">
                </div>

                <div class="form-group">
                  <label>Chi tiết công việc</label>
                  <input type="text" class="form-control" id="detail" name="detail" value="{{ $getRecord->detail }}" placeholder="Chi tiết công việc">
                </div>

                <div class="form-group">
                  <label>Thời gian giao dịch</label>
                  <input placeholder="Deadline" value="{{ $getRecord->deadline }}" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="deadline" name="deadline" />
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