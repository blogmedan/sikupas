@extends('layouts.app')

@section('content')
@foreach($guru as $p)
    <section class="content-header">
      <h1>
        Data Guru {{$p->n_guru}}
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Data Guru</li>
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
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                  <label>NIP</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->nip}}">
                </div>
                <div class="form-group">
                  <label>NUPTK</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->nuptk}}">
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->n_guru}}">
                </div>
                <div class="form-group">
                  <label>Pangkat</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->pangkat}}">
                </div>
                <div class="form-group">
                  <label>Jabatan</label>
                  <input type="text" class="form-control" disabled="disabled" value="{{$p->jabatan}}">
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
                  <a href="/sikupas/public/daftarguru/edit/{{$p->id_guru}}" class="btn btn-primary">Ubah</a>
                </div>
                @elseif(Session::get('level')=="guru")
                <div class="box-footer">
                  <a href="/sikupas/public/daftarguru/edit/{{Session::get('id')}}" class="btn btn-primary">Ubah</a>
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