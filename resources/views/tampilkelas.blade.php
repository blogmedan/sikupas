@extends('layouts.app')

@section('content')
@foreach($kelas as $p)
    <section class="content-header">
      <h1>
        Data Kelas {{$p->n_kelas}}
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Kelas</li>
      </ol>
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Info Kelas {{$p->n_kelas}}</h3>
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
            <div class="container">
          <a href="/sikupas/public/daftarkelas/tampil/tambah/{{$p->id_kelas}}" class="btn btn-success my-3"><i class="fa fa-plus"></i> Siswa</a>
          <!--button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
            IMPORT EXCEL
          </button>
          <a href="#" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
          <a href="#" class="btn btn-success my-3" target="_blank">DOWNLOAD TEMPLATE</a-->
          </div>
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Selamat Datang</h3>
            </div>
            <div class="box-body">
                <strong><i class="fa fa-book margin-r-5"></i> Kelas/Jurusan</strong>
                <p class="text-muted">{{$p->n_kelas}}</p>
                <hr>
                <strong><i class="fa fa-user margin-r-5"></i>Wali Kelas</strong>
                <p class="text-muted">{{$p->n_w_kelas}}</p>
                <hr>
          @endforeach
            </div>
        </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Siswa</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Siswa</th>
                  <th>Jenis Kelamin</th>
                  <th>Agama</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($siswakelas as $l_s)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$l_s->nama}}</td>
                  <td>{{$l_s->j_kelamin}}</td>
                  <td>{{$l_s->agama}}</td>
                  <td><a href="/sikupas/public/daftarkelas/tampil/deletesis/{{$l_s->id_kelas}}/{{$l_s->id_siswa}}"><i class="fa fa-trash-o"></i> Hapus</a></td>
                </tr>
                @endforeach             
                </tbody>
                <tfoot>
                <tr>
                  <th>#</th>
                  <th>NPSN</th>
                  <th>Nama Skolah</th>
                  <th>Kepala Sekolah</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
@endsection