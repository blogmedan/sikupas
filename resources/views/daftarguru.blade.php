@extends('layouts.app')

@section('content')

    <section class="content-header">
      <h1>
        Data Guru @if(Session::get('login')) {{Session::get('name')}} @endif
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Guru @if(Session::get('login')) {{Session::get('name')}} @endif</li>
      </ol>
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Guru Baru</h3>
            </div>
            {{-- notifikasi form validasi --}}
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
          <a href="#" class="btn btn-success my-3" data-toggle="modal" data-target="#tambahguru"><i class="fa fa-plus" ></i> Guru</a>
          <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
          <i class="fa fa-upload"></i> IMPORT
          </button>
          <a href="templateguru.xlsx" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> TEMPLATE</a>
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
          <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="{{url('daftarguru/import')}}" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Guru</h5>
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
                    <input type="submit" class="btn btn-primary" name="import" name="Import">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- Tambah Guru -->
          <div class="modal fade" id="tambahguru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="/sikupas/public/daftarguru/prosesreg"" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Guru</h5>
                  </div>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label>Nama</label>
                      <input type="text" name="nama" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" name="username" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    @if(Session::get('name')=="admin")
                    <div class="form-group">
                      <label>Asal Sekolah</label>
                      <select name="a_sekolah" class="form-control" placeholder="Enter ..." required="required">
                      @foreach($sekolah as $s)
                      <option value="{{$s->n_sekolah}}">{{$s->n_sekolah}}</option>
                      @endforeach
                      </select>
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
          <!--a href="#" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> EXPORT</a>
          <a href="#" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> DOWNLOAD</a-->
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
              <h3 class="box-title">Data Guru @if(Session::get('login')) {{Session::get('name')}} @endif</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <form method="post" action="{{url('daftarguru/deletcek')}}">
            {{ csrf_field() }}
            <input type="submit" class="btn btn-primary mr-5" name="hapuscek" value="Hapus">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Pangkat</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @php $i=1 @endphp
                @foreach($guru as $l_s)
                <tr>
                  <td><input type="checkbox" name="id_guru[]" value="{{$l_s->id_guru}}"></td>
                  <td>{{$l_s->nip}}</td>
                  <td>{{$l_s->n_guru}}</td>
                  <td>{{$l_s->pangkat}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info">Action</button>
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        @if(Session::get('level')=="sekolah" or Session::get('level')=="admin")
                        <li><a href="/sikupas/public/daftarguru/tampil/{{$l_s->id_guru}}"><i class="fa fa-eye"></i>Lihat</a></li>
                          @if(Session::get('level')=="sekolah")
                          <li><a href="/sikupas/public/daftarguru/edit/{{$l_s->id_guru}}"><i class="fa fa-edit"></i>Edit</a></li>
                          <li><a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarguru/delete/{{$l_s->id_guru}}"><i class="fa fa-trash-o"></i>Hapus</a></li>
                          @endif
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
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Pangkat</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </form>
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