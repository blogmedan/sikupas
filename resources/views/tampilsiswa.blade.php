@extends('layouts.app')

@section('content')
    <section class="content-header">
      <h1>
        Informasi Siswa
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Informasi Siswa</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="box">
          <div class="box box-warning">
            @foreach($siswa as $p)
            <div class="box-header with-border">
              <h3 class="box-title">Data {{$p->nama}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                  <label>NISN</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->nisn}}">
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->nama}}">
                </div>
                <div class="form-group">
                  <label>Agama</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->agama}}">
                </div>
                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->j_kelamin}}">
                </div>
                <div class="form-group">
                  <label>Tempat Lahir</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->t_lahir}}">
                </div>
                <div class="form-group">
                  <label>Tanggal Lahir</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->tgl_lahir}}">
                </div>
                <div class="form-group">
                  <label>Kelas</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->kelas}}">
                </div>
                <div class="form-group">
                  <label>Asal Sekolah</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->a_sekolah}}">
                </div>
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->username}}">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->password}}">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->email}}">
                </div>
                <div class="form-group">
                  <label>Bergabung Pada</label>
                  <input type="text" name="npsn" class="form-control" disabled="disabled" value="{{$p->created_at}}">
                </div>
                @if(Session::get('level')=="admin" or Session::get('level')=="sekolah")
                <div class="box-footer">
                  <a href="/sikupas/public/daftarsiswa/edit/{{$p->id_siswa}}" class="btn btn-primary">Ubah</a>
                </div>
                @elseif(Session::get('level')=="siswa")
                <div class="box-footer">
                  <a href="/sikupas/public/daftarsiswa/edit/{{Session::get('id')}}" class="btn btn-primary">Ubah</a>
                </div>
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