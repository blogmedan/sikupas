@extends('layouts.app')

@section('content')
@foreach($sekolah as $p)
    <section class="content-header">
      <h1>
        Edit Sekolah {{$p->n_sekolah}}
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Edit Sekolah</li>
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
            @if ($gagal = Session::get('gagal'))
            <div class="alert alert-danger">
              <div><strong>{{$gagal}}</strong></div>
            </div>
            @endif
            @if ($sukses = Session::get('sukses'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $sukses }}</strong>
            </div>
            @endif
            <div class="container">
            <div class="box-body">
              <form role="form" action="/sikupas/public/daftarsekolah/prosesedit" method="POST">
                <!-- text input -->
                {{ csrf_field() }}
                <input type="hidden" name="id_sekolah" value="{{ $p->id_sekolah }}">
                <div class="form-group">
                  <label>NPSN</label>
                  <input type="text" name="npsn" class="form-control" placeholder="Enter ..." required="required" value="{{$p->npsn}}" @if(Session::get('level')=="sekolah") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>Status Sekolah</label>
                  <select name="status" class="form-control" required="required" @if(Session::get('level')=="sekolah") disabled="disabled" @endif>
                    <option value="{{$p->status}}">{{$p->status}}</option>
                    <option value="Negeri">Negeri</option>
                    <option value="Swasta">Swasta</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Nama Sekolah</label>
                  <input type="text" name="n_sekolah" class="form-control" placeholder="Enter ..." required="required" value="{{$p->n_sekolah}}"  @if(Session::get('level')=="sekolah") disabled="disabled" @endif>
                </div>
                <div class="form-group">
                  <label>Nama Kepala Sekolah</label>
                  <input type="text" name="n_k_sekolah" class="form-control" placeholder="Enter ..." required="required" value="{{$p->n_k_sekolah}}">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" class="form-control" placeholder="Enter ..." required="required" value="{{$p->email}}">
                </div>
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Enter ..." required="required" value="{{$p->username}}">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control" placeholder="Enter ..." required="required" value="{{Crypt::decrypt($p->password)}}">
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" rows="3" name="a_sekolah" placeholder="Enter ..." required="required">{{$p->a_sekolah}}</textarea>
                </div>

                <!--div class="form-group">
                  <label for="exampleInputFile">Upload File</label>
                  <input name="f_sekolah" type="file" id="exampleInputFile">

                  <p class="help-block">File type:pdf/Size Max 3Mb</p>
                </div>
                <div class="form-group has-success">
                  <label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Input with success</label>
                  <input type="text" class="form-control" id="inputSuccess" placeholder="Enter ...">
                  <span class="help-block">Help block with success</span>
                </div>
                <div class="form-group has-warning">
                  <label class="control-label" for="inputWarning"><i class="fa fa-bell-o"></i> Input with
                    warning</label>
                  <input type="text" class="form-control" id="inputWarning" placeholder="Enter ...">
                  <span class="help-block">Help block with warning</span>
                </div>
                <div class="form-group has-error">
                  <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Input with
                    error</label>
                  <input type="text" class="form-control" id="inputError" placeholder="Enter ...">
                  <span class="help-block">Help block with error</span>
                </div-->
                <div class="box-footer">
                  <input type="submit" class="btn btn-primary" name="update" value="Simpan">
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