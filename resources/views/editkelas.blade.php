@extends('layouts.app')

@section('content')
    @foreach($kelas as $p)
    @endforeach
    <section class="content-header">
      <h1>
        Edit Kelas
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Edit Kelas</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Kelas {{$p->n_kelas}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="/sikupas/public/daftarkelas/prosesedit" method="POST">
                <!-- text input -->
                {{ csrf_field() }}
                <input type="hidden" name="id_kelas" value="{{ $p->id_kelas }}">
                  <div class="form-group">
                    <label>Nama Kelas</label>
                    <input type="text" name="n_kelas" value="{{$p->n_kelas}}" class="form-control" placeholder="Enter ..." required="required">
                  </div>
                  <div class="form-group">
                    <label>Nama Wali Kelas</label>
                    <select name="n_w_kelas" class="form-control select2" style="width: 100%;">
                      <option value="{{$p->n_w_kelas}}">{{$p->n_w_kelas}}</option>
                      @foreach($guru as $w)
                          <option value="{{$w->n_guru}}">{{$w->n_guru}}</option>
                      @endforeach
                    </select>
                    <!--input type="text" name="n_w_kelas" value="{{$p->n_w_kelas}}" class="form-control" placeholder="Enter ..." required="required"-->
                  </div>
                  @if(!Session::get('name'))
                  <div class="form-group">
                    <label>Asal Sekolah</label>
                    <input type="text" name="a_sekolah" value="{{$p->a_sekolah}}" class="form-control" placeholder="Enter ..." required="required">
                  </div>
                  @endif
                  </div>                  
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
  @endsection