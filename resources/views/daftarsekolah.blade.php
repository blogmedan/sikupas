@extends('layouts.app')

@section('content')
    <section class="content-header">
      <h1>
        Data Sekolah Yang Terdaftar
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Sekolah</li>
      </ol>
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Sekolah Baru</h3>
            </div>
            {{-- notifikasi form validasi
            @if ($errors->has('file'))--}}
            <!--span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('file') }}</strong>
            </span-->
            {{--@endif--}}
        
            {{-- notifikasi sukses --}}
            @if ($gagal = Session::get('gagal'))
            <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button> 
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
            <a href="#" class="btn btn-success my-3" data-toggle="modal" data-target="#tambahsekolah"><i class="fa fa-plus"></i> Sekolah</a>
            <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
            <i class="fa fa-upload"></i> IMPORT
            </button>
            <a href="templatesekolah.xlsx" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> TEMPLATE</a>
          <!-- Import Excel -->
          <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="{{url('daftarsekolah/import')}}" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Sekolah</h5>
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
          </div>
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
          <!-- Import Excel -->
          <div class="modal fade" id="tambahsekolah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="{{url('daftarsekolah/prosesreg')}}" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Sekolah</h5>
                  </div>
                  <div class="modal-body">
       
                    {{ csrf_field() }}
       
                    <div class="form-group">
                      <label>NPSN</label>
                      <input type="text" name="npsn" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                      <label>Status Sekolah</label>
                      <select name="status" class="form-control" required="required">
                        <option value="Negeri">Negeri</option>
                        <option value="Swasta">Swasta</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Nama Sekolah</label>
                      <input type="text" name="n_sekolah" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                      <label>Nama Kepala Sekolah</label>
                      <input type="text" name="n_k_sekolah" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" name="username" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                      <label>Alamat</label>
                      <textarea class="form-control" rows="3" name="a_sekolah" placeholder="Enter ..." required="required"></textarea>
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
          <!--a href="#" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> EXPORT</a>
          <a href="#" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> TEMPLATE</a-->
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
                  <th>NPSN</th>
                  <th>Nama Skolah</th>
                  <th>Kepala Sekolah</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($sekolah as $l_s)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$l_s->npsn}}</td>
                  <td>{{$l_s->n_sekolah}}</td>
                  <td>{{$l_s->n_k_sekolah}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info">Action</button>
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="/sikupas/public/daftarsekolah/tampil/{{$l_s->id_sekolah}}"><i class="fa fa-eye"></i>Lihat</a></li>
                        <li><a href="/sikupas/public/daftarsekolah/edit/{{$l_s->id_sekolah}}"><i class="fa fa-edit"></i>Edit</a></li>
                        <li><a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarsekolah/delete/{{$l_s->id_sekolah}}"><i class="fa fa-trash-o"></i>Hapus</a></li>
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