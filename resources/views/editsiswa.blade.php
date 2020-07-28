@extends('layouts.app')

@section('content')
@foreach($siswa as $p)
    <section class="content-header">
      <h1>
        Ubah Siswa {{$p->nama}}
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Ubah Siswa</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah {{$p->nama}}</h3>
            </div>
            @if ($gagal = Session::get('gagal'))
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <div><strong>{{$gagal}}</strong></div>
            </div>
            @endif
            {{-- notifikasi sukses --}}
            @if ($sukses = Session::get('sukses'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $sukses }}</strong>
            </div>
            @endif
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="{{url('daftarsiswa/prosesedit')}}" method="POST">
                <!-- text input -->
                {{ csrf_field() }}
                <input type="hidden" name="id_siswa" value="{{$p->id_siswa}}">
                <div class="form-group">
                  <label>NISN</label>
                  <input type="text" name="nisn" class="form-control" placeholder="Enter ..." required="required" value="{{$p->nisn}}" @if(Session::get('level')=="siswa") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control" placeholder="Enter ..." required="required" value="{{$p->nama}}" @if(Session::get('level')=="siswa") disabled="disabled" @endif>
                </div>
                <!--div class="form-group">
                  <label>Agama</label>
                  <input type="text" name="agama" class="form-control" placeholder="Enter ..." required="required" value="{{$p->agama}}" @if(Session::get('level')=="siswa") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <input type="text" name="j_kelamin" class="form-control" placeholder="Enter ..." required="required" value="{{$p->j_kelamin}}" @if(Session::get('level')=="siswa") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>Tempat Lahir</label>
                  <input type="text" name="t_lahir" class="form-control" placeholder="Enter ..." required="required" value="{{$p->t_lahir}}" @if(Session::get('level')=="siswa") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>Tanggal Lahir</label>
                  <input type="date" name="tgl_lahir" class="form-control" placeholder="Enter ..." required="required" value="{{$p->tgl_lahir}}" @if(Session::get('level')=="siswa") disabled="disabled" @endif>
                </div-->
                <div class="form-group">
                  <label>Agama</label>
                  <select name="agama" class="form-control" required="required">
                    <option value="{{$p->agama}}">{{$p->agama}}</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Budha">Budha</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <select name="j_kelamin" class="form-control" required="required">
                    <option value="{{$p->j_kelamin}}">{{$p->j_kelamin}}</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Tempat Lahir</label>
                  <input type="text" name="t_lahir" class="form-control" placeholder="Enter ..." required="required" value="{{$p->t_lahir}}">
                </div>
                <div class="form-group">
                  <label>Tanggal Lahir</label>
                  <input type="date" name="tgl_lahir" class="form-control" placeholder="Enter ..." required="required" value="{{$p->tgl_lahir}}">
                </div>
                <!--div class="form-group">
                  <label>Kelas</label>
                  <input type="text" name="kelas" class="form-control" placeholder="Enter ..." required="required" value="{{$p->kelas}}" @if(Session::get('level')=="siswa") disabled="disabled" @endif>
                </div-->
                @if(Session::get('level')=="admin")
                <div class="form-group">
                  <label>Asal Sekolah</label>
                  <input type="text" name="a_sekolah" class="form-control" placeholder="Enter ..." required="required" value="{{$p->a_sekolah}}" @if(Session::get('level')=="siswa") disabled="disabled" @endif>
                </div>
                @endif
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Enter ..." required="required" value="{{$p->username}}" disabled="disabled">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control" placeholder="Enter ..." required="required" value="{{Crypt::decrypt($p->password)}}">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" class="form-control" placeholder="Enter ..." required="required" value="{{$p->email}}">
                </div>
                <div class="box-footer">
                  <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                </div>

              </form>
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