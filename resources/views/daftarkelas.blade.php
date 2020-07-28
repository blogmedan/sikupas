@extends('layouts.app')

@section('content')

    <section class="content-header">
      <h1>
        Data Kelas
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
              <h3 class="box-title">Daftar Kelas</h3>
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
          <button type="button" class="btn btn-success my-3" data-toggle="modal" data-target="#tambahkelas"><i class="fa fa-plus"></i>
            Kelas
          </button>
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
          <div class="modal fade" id="tambahkelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="{{url('daftarkelas/prosesreg')}}">
              {{ csrf_field() }}
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar Kelas Baru</h5>
                  </div>
                  <div class="modal-body">
                  <div class="form-group">
                    <label>Nama Kelas</label>
                    <input type="text" name="n_kelas" class="form-control" placeholder="Enter ..." required="required">
                  </div>
                  <div class="form-group">
                    <label>Nama Wali Kelas</label>
                    <select name="n_w_kelas" class="form-control select2" style="width: 100%;">
                      @foreach($guru as $w)
                          <option value="{{$w->n_guru}}">{{$w->n_guru}}</option>
                      @endforeach
                    </select>
                    <!--input type="text" name="n_w_kelas" class="form-control" placeholder="Enter ..." required="required"-->
                  </div>
                  @if(!Session::get('name'))
                  <div class="form-group">
                    <label>Asal Sekolah</label>
                    <input type="text" name="a_sekolah" class="form-control" placeholder="Enter ..." required="required">
                  </div>
                  @endif
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="tambah" value="Tambah">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- Import Excel -->
          <!--div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="/cabdissunggal/public/daftarsekolah/import" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
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
                    <button type="submit" class="btn btn-primary">Import</button>
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
              <h3 class="box-title">Data Sekolah</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Kelas</th>
                  <th>Nama Wali Kelas</th>
                  <th>Asal Sekolah</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($kelas as $l_s)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$l_s->n_kelas}}</td>
                  <td>{{$l_s->n_w_kelas}}</td>
                  <td>{{$l_s->a_sekolah}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info"><i class="fa fa-eye"></i></button>
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="/sikupas/public/daftarkelas/tampil/{{$l_s->id_kelas}}"><i class="fa fa-eye"></i> Lihat</a></li>
                        @if(Session::get('level')=="sekolah")
                        <li><a href="/sikupas/public/daftarkelas/edit/{{$l_s->id_kelas}}"><i class="fa fa-edit"></i> Edit</a></li>
                        <li><a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarkelas/delete/{{$l_s->id_kelas}}"><i class="fa fa-trash-o"></i> Hapus</a></li>
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