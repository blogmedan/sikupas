@extends('layouts.app')

@section('content')

    <section class="content-header">
      <h1>
        Data Mata Pelajaran
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Pelajaran</li>
      </ol>
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Pelajaran</h3>
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
          <button type="button" class="btn btn-success my-3" data-toggle="modal" data-target="#tambahpelajaran"><i class="fa fa-plus"></i>
            Pelajaran
          </button>
          <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#importPelajaran"><i class="fa fa-upload"></i>
            Import
          </button>
          <a href="templatepelajaran.xlsx" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> TEMPLATE</a>
          <!--button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
          <i class="fa fa-upload"></i> IMPORT
          </button-->
          <!-- Konfirmasi Hapus -->
          <div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <b>Anda yakin ingin menghapus data ini ?</b><br><br>
                        <a class="btn btn-danger btn-ok"> Hapus</a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
                    </div>
                </div>
            </div>
          </div>
          <!-- Tambah Kelas -->
          <div class="modal fade" id="tambahpelajaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="{{url('daftarpelajaran/prosesreg')}}">
              {{ csrf_field() }}
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar Pelajaran Baru</h5>
                  </div>
                  <div class="modal-body">
                  <div class="form-group">
                    <label>Kode Mata Pelajaran</label>
                    <input type="text" name="kode" class="form-control" placeholder="Enter ..." required="required">
                  </div>
                  <div class="form-group">
                    <label>Nama Mata Pelajaran</label>
                    <input type="text" name="n_pelajaran" class="form-control" placeholder="Enter ..." required="required"-->
                  </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="tambah" value="Tambah">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- Import Pelajaran -->
          <div class="modal fade" id="importPelajaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="{{url('daftarpelajaran/import')}}" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Pelajaran</h5>
                  </div>
                  <div class="modal-body">
       
                    {{ csrf_field() }}
       
                    <label>Pilih file excel</label>
                    <div class="form-group">
                      <input type="file" name="file" required="required">
                    </div>
       
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="import" value="Import">
                  </div>
                </div>
              </form>
            </div>
          </div-->
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
              <h3 class="box-title">Data Mata Pelajaran</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Kode Pelajaran</th>
                  <th>Mata Pelajaran</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($matapelajaran as $m_p)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$m_p->kode}}</td>
                  <td>{{$m_p->n_pelajaran}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info">Action</button>
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        @if(Session::get('level')=="sekolah")
                        <li><a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarpelajaran/delete/{{$m_p->id_matapelajaran}}"><i class="fa fa-trash-o"></i> Hapus</a></li>
                        @endif
                      </ul>
                    </div>                    
                  </td>
                </tr>
                @endforeach             
                </tbody>
                <tfoot>
                <tr>
                  <th>#</th>
                  <th>Kode Pelajaran</th>
                  <th>Mata Pelajaran</th>
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