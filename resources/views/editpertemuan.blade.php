@extends('layouts.app')

@section('content')
@foreach($pertemuan as $p)
    <section class="content-header">
      <h1>
        Ubah Data {{$p->n_pertemuan}}
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Ubah Pertemuan</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Data {{$p->n_pertemuan}}</h3>
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
              <form role="form" action="/sikupas/public/daftarpertemuan/prosesedit" method="POST">
                <!-- text input -->
                {{ csrf_field() }}
                <input type="hidden" name="id_pertemuan" value="{{$p->id_pertemuan}}">
                <div class="form-group">
                  <label>Nama Mata Pelajaran</label>
                  <select name="id_matapelajaran" class="form-control select2" style="width: 100%;" placeholder="Enter ..." required="required"> 
                  <?php 
                  $n_pelajaran=DB::table('matapelajaran')->where('id_matapelajaran',$p->id_matapelajaran)->get();
                  $j_pelajaran=count($n_pelajaran);
                  ?>
                  @if($j_pelajaran==0)
                  <option>Pelajaran Kosong Tolong Pilih Pelajaran</option>
                  @else
                  @foreach($n_pelajaran as $pelaj)
                  @endforeach
                  <option value="{{$pelaj->id_matapelajaran}}">{{$pelaj->n_pelajaran}}</option>
                  @endif
                  @foreach($pelajaran as $pel)
                  <option value="{{$pel->id_matapelajaran}}">{{$pel->n_pelajaran}}</option>
                  @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Nama Pertemuan</label>
                  <input type="text" name="n_pertemuan" class="form-control" value='{{$p->n_pertemuan}}' required="required">
                </div>
                <!--div class="form-group">
                  <label>Pilih Kelas</label>
                  <select name="id_kelas" class="form-control select2" style="width: 100%;">
                  <option value="{{$p->id_kelas}}">{{$p->n_kelas}}</option>
                  @foreach($kelas as $k)
                  <option value="{{$k->id_kelas}}">{{$k->n_kelas}}</option>
                  @endforeach
                  </select>
                </div-->
                <!--div class="form-group">
                  <label>Tanggal Pertemuan</label>
                  <input type="date" id="datepicker" name="tgl_pertemuan" value='{{$p->tgl_pertemuan}}' class="form-control" required="required">
                </div-->
                <div class="form-group">
                  <label>Embet Youtube Video Pembelajaran</label>
                  <input type="text" name="l_v_pembelajaran" class="form-control" value='{{$p->l_v_pembelajaran}}' placeholder="Ex = h2JFceJFuhg" required="required">
                </div>
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