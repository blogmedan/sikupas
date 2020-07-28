@extends('layouts.app')

@section('content')
@foreach($sekolah as $p)
    <section class="content-header">
      <h1>
        Ubah Data Sekolah {{$p->n_sekolah}}
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Ubah Sekolah</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Data Sekolah {{$p->n_sekolah}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                  <label>NPSN</label>
                  <input type="text" name="npsn" class="form-control" disabled="disabled" value="{{$p->npsn}}">
                </div>
                <div class="form-group">
                  <label>Status Sekolah</label>
                  <select name="status" class="form-control" disabled="disabled">
                    <option value="{{$p->status}}">{{$p->status}}</option>
                    <option value="Negeri">Negeri</option>
                    <option value="Swasta">Swasta</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Nama Sekolah</label>
                  <input type="text" name="n_sekolah" class="form-control" disabled="disabled" value="{{$p->n_sekolah}}">
                </div>
                <div class="form-group">
                  <label>Nama Kepala Sekolah</label>
                  <input type="text" name="n_k_sekolah" class="form-control" disabled="disabled" value="{{$p->n_k_sekolah}}">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" class="form-control" disabled="disabled" value="{{$p->email}}">
                </div>
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" disabled="disabled" value="{{$p->username}}">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control" disabled="disabled" value="{{$p->password}}">
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" rows="3" name="a_sekolah" disabled="disabled">{{$p->a_sekolah}}</textarea>
                </div>
                @if(Session::get('level')=="admin")
                <div class="box-footer">
                  <a href="/sikupas/public/daftarsekolah/edit/{{$p->id_sekolah}}" class="btn btn-primary">Ubah</a>
                </div>
                @elseif(Session::get('level')=="sekolah")
                <a href="/sikupas/public/daftarsekolah/edit/{{Session::get('id_sekolah')}}" class="btn btn-primary">Ubah</a>
                @endif
              @endforeach
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