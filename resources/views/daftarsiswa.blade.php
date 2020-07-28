@extends('layouts.app')

@section('content')

    <section class="content-header">
      <h1>
        Data Siswa {{Session::get('name')}}
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Siswa {{Session::get('name')}}</li>
      </ol>
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Siswa Baru</h3>
            </div>
            @if ($gagal = Session::get('gagal'))--}}
            {{--@$i=0--}}
            {{--@foreach($gagal as $t_gagal)--}}
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <div><strong>{{$gagal}}</strong></div>
            </div>
            {{--$i++--}}
            {{--@endforeach--}}
            @endif
            {{-- notifikasi sukses --}}
            @if ($sukses = Session::get('sukses'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $sukses }}</strong>
            </div>
            @endif
            <div class="container">
          <a href="#" class="btn btn-success my-3" data-toggle="modal" data-target="#tambahsiswa"><i class="fa fa-plus"></i> Siswa</a>
          <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
          <i class="fa fa-upload"></i> IMPORT
          </button>
          <a href="templatesiswa.xlsx" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> TEMPLATE</a>
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
              <?php
              if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "07:00:00")){
              ?>
              <form method="post" action="{{url('daftarsiswa/import')}}" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Siswa</h5>
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
              <?php
              }else{
              ?>
                <div class="modal-content">
                  <div class="form-group">
                    <h3 style="text-align: center; color: red;">Maaf Akses dibuka Pukul<br> 15:00:00 WIB(Sore)<br>Terima Kasih</h3>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <!-- Tambah Siswal -->
          <div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <?php
              if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "07:00:00")){
              ?>
              <form method="post" action="{{url('daftarsiswa/prosesreg')}}" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                  </div>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label>Nama</label>
                      <input type="text" name="nama" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                      <label>Agama</label>
                      <select name="agama" class="form-control" placeholder="Enter ..." required="required">
                        <option value="Islam">Islam</option>
                        <option value="kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                      </select>
                      <!--input type="text" name="agama" class="form-control" placeholder="Enter ..." required="required"-->
                    </div>
                    <div class="form-group">
                      <label>Jenis Kelamin</label>
                      <select name="j_kelamin" class="form-control" placeholder="Enter ..." required="required">
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                      <!--input type="text" name="j_kelamin" class="form-control" placeholder="Enter ..." required="required"-->
                    </div>
                    <div class="form-group">
                      <label>Kelas</label>
                      <input type="text" name="kelas" class="form-control" placeholder="Enter ..." required="required">
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
              <?php
              }else{
              ?>
                <div class="modal-content">
                  <div class="form-group">
                    <h3 style="text-align: center; color: red;">Maaf Akses dibuka Pukul<br> 15:00:00 WIB(Sore) sampai Pukul 07:00:00 WIB(Pagi)<br>Terima Kasih</h3>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <!--a href="#" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> EXPORT</a>
          <a href="#" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> DOWNLOAD TEMPLATE</a-->
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
              <h3 class="box-title">Data Siswa {{Session::get('name')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <form method="post" action="{{url('daftarsiswa/deletcek')}}">
            {{ csrf_field() }}
            <input type="submit" class="btn btn-primary mr-5" name="hapuscek" value="Hapus">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>NISN</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Kelas</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @php $i=1 @endphp
                @foreach($siswa as $l_s)
                <tr>
                  <td><input type="checkbox" name="id_siswa[]" value="{{$l_s->id_siswa}}"></td>
                  <td>{{$l_s->nisn}}</td>
                  <td>{{$l_s->nama}}</td>
                  <td>{{$l_s->username}}</td>
                  <td>{{$l_s->kelas}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info">Action</button>
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                      @if(Session::get('level')=="sekolah" or Session::get('level')=="admin")
                        <li><a href="/sikupas/public/daftarsiswa/tampil/{{$l_s->id_siswa}}"><i class="fa fa-eye"></i>Lihat</a></li>
                        @if(Session::get('level')=="sekolah")
                        <li><a href="/sikupas/public/daftarsiswa/edit/{{$l_s->id_siswa}}"><i class="fa fa-edit"></i>Edit</a></li>
                        <li><a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarsiswa/delete/{{$l_s->id_siswa}}"><i class="fa fa-trash-o"></i>Hapus</a></li>
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
                  <th>NISN</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Kelas</th>
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