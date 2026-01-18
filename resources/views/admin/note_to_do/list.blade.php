@extends('layouts.app')

@section('content')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Công việc cần làm</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- THÊM MỚI CÔNG VIỆC -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Thêm mới công việc</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="">
              {{ csrf_field() }}
              <div class="form-group row"> </div>
              <div class="form-group row">
                <div class="col-sm-2 mb-3 mb-sm-0" style="margin-left: 25px;">
                  <select class="form-control" required id="priority" name="priority" placeholder="Độ ưu tiên">
                    <option value="" disabled selected>Độ ưu tiên</option>
                    <option value="Normal">Bình thường</option>
                    <option value="Emergency">Khẩn cấp</option>
                  </select>
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <input type="text" class="form-control" id="work" name="work" required placeholder="Công việc">
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <input type="text" class="form-control" id="detail" name="detail" required placeholder="Chi tiết công việc">
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <input type="text" class="form-control" id="state" name="state" required placeholder="Trạng thái">
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <input placeholder="Deadline" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="deadline" name="deadline" required />
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

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title card-primary">Nội dung công việc (Tổng: {{ $getRecord->total() }})</h3>
            </div>

            <!-- Tìm kiếm -->
            <form method="get" action="">
              <div class="form-group row"> </div>
              <div class="form-group row">
                <div class="col-sm-2 mb-3 mb-sm-0" style="margin-left: 25px;">
                  <label>Độ ưu tiên</label>
                  <select class="form-control" id="s_priority" name="s_priority" placeholder="Độ ưu tiên">
                    <option value="">Độ ưu tiên</option>
                    <option value="Normal">Bình thường</option>
                    <option value="Emergency">Khẩn cấp</option>
                  </select>
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <label>Công việc</label>
                  <input type="text" class="form-control" id="s_work" name="s_work" placeholder="Công việc">
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <label>Chi tiết công việc</label>
                  <input type="text" class="form-control" id="s_detail" name="s_detail" placeholder="Chi tiết công việc">
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                  <label>Trạng thái</label>
                  <input type="text" class="form-control" id="s_state" name="s_state" placeholder="Trạng thái">
                </div>
                <button class="btn btn-primary" type="Submit" style="margin-top: 30px;">Search</button>
                <a></a>
                <a href="{{ url('admin/note_to_do/list') }}" class="btn btn-success" style="margin-top: 30px; margin-left: 5px;">Reset</a>
              </div>
            </form>
            <!-- Tìm kiếm -->

            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Công việc</th>
                    <th>Nội dung chi tiết</th>
                    <th>Độ ưu tiên</th>
                    <th>Trạng thái</th>
                    <th>Deadline</th>
                    <th>Thời gian tạo</th>
                    <th>Thời gian cập nhật</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($getRecord as $value)
                  <tr>
                    <td>{{ $value->work }}</td>
                    <td>{{ $value->detail }}</td>
                    <td>{{ $value->priority }}</td>
                    <td>{{ $value->state }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->deadline)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->updated_at)) }}</td>
                    <td>
                      <a href="{{ url('admin/note_to_do/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                      <a href="{{ url('admin/note_to_do/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
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