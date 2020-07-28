@extends('layouts.app')

@section('content')
@foreach($guru as $p)
    <section class="content-header">
      <h1>
        Ubah Data {{$p->n_guru}}
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Ubah Guru</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Data {{$p->n_guru}}</h3>
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
              <form role="form" action="/sikupas/public/daftarguru/prosesedit" method="POST">
                <!-- text input -->
                {{ csrf_field() }}
                <input type="hidden" name="id_guru" value="{{ $p->id_guru }}">
                <!--div class="form-group">
                  <label>NIP</label>
                  <input type="text" name="nip" class="form-control" placeholder="Enter ..." required="required" value="{{$p->nip}}" @if(Session::get('level')=="guru") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>NUPTK</label>
                  <input type="text" name="nuptk" class="form-control" placeholder="Enter ..." required="required" value="{{$p->nuptk}}" @if(Session::get('level')=="guru") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="n_guru" class="form-control" placeholder="Enter ..." required="required" value="{{$p->n_guru}}" @if(Session::get('level')=="guru") disabled="disabled" @endif>
                </div-->
                <div class="form-group">
                  <label>NIP</label>
                  <input type="text" name="nip" class="form-control" placeholder="Enter ..." required="required" value="{{$p->nip}}" @if(Session::get('level')=="guru") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>NUPTK</label>
                  <input type="text" name="nuptk" class="form-control" placeholder="Enter ..." required="required" value="{{$p->nuptk}}">
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="n_guru" class="form-control" placeholder="Enter ..." required="required" value="{{$p->n_guru}}">
                </div>
                <div class="form-group">
                  <label>Pangkat</label>
                  <input type="text" name="pangkat" class="form-control" placeholder="Enter ..." required="required" value="{{$p->pangkat}}" @if(Session::get('level')=="guru") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>Jabatan</label>
                  <input type="text" name="jabatan" class="form-control" placeholder="Enter ..." required="required" value="{{$p->jabatan}}" @if(Session::get('level')=="guru") disabled="disabled" @endif>
                </div>
                @if(Session::get('level')=="admin")
                <div class="form-group">
                  <label>Asal Sekolah</label>
                  <input type="text" name="a_sekolah" class="form-control" placeholder="Enter ..." required="required" value="{{$p->a_sekolah}}" @if(Session::get('level')=="guru") disabled="disabled" @endif>
                </div>
                @endif
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Enter ..." required="required" value="{{$p->username}}">
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