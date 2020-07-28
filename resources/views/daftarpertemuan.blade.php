@extends('layouts.app')

@section('content')
    <section class="content-header">
      <h1>
        Data Pertemuan Yang Terdaftar
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Pertemuan</li>
      </ol>
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Pertemuan Baru</h3>
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
          @if(Session::get('level')=="guru")
          <button type="button" class="btn btn-success my-3" data-toggle="modal" data-target="#tambahpertemuan"><i class="fa fa-plus"></i>
            Pertemuan
          </button>
          @endif
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
          <!-- Tambah Pertemuan -->
          @if(Session::get('level')=="guru")
          <div class="modal fade" id="tambahpertemuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <?php
              if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "08:00:00")){
              ?>
              <form method="post" action="{{url('daftarpertemuan/prosesreg')}}">
              {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Daftar Pertemuan Baru</h5>
                    </div>                    
                    <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Mata Pelajaran</label>
                        <select name="id_matapelajaran" class="form-control select2" style="width: 100%;" placeholder="Enter ..." required="required"> 
                          @foreach($pelajaran as $pel)
                              <option value="{{$pel->id_matapelajaran}}">{{$pel->n_pelajaran}}</option>
                          @endforeach
                        </select>
                        <!--input type="text" name="n_m_pelajaran" class="form-control" placeholder="Enter ..." required="required"-->
                    </div>
                    <div class="form-group">
                        <label>Nama Pertemuan</label>
                        <input type="text" name="n_pertemuan" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                        <label>Pilih Kelas</label>
                        <select name="id_kelas" class="form-control select2" style="width: 100%;">
                        @foreach($kelas as $p)
                            <option value="{{$p->id_kelas}}">{{$p->n_kelas}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pertemuan</label>
                        <input type="date" id="datepicker" name="tgl_pertemuan" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                    <label>Embet Youtube Video Pembelajaran</label>
                        <input type="text" name="l_v_pembelajaran" class="form-control" placeholder="Ex = h2JFceJFuhg" required="required">
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
              <?php
              }else{
              ?>
                <div class="modal-content">
                  <div class="form-group">
                    <h3 style="text-align: center; color: red;">Maaf Penambahan Pertemuan Dilakukan Pukul<br> 15:00:00 WIB(Sore) sampai Pukul 08:00:00 WIB(Pagi)<br>Terima Kasih</h3>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          @endif
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
              <h3 class="box-title">Data Pertemuan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Pertemuan</th>
                  <th>Mata Pelajaran</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($pertemuan as $l_s)
                <tr>
                  <td>{{$i++}}</td>
                  <td><a href="/sikupas/public/daftarpertemuan/tampil/{{$l_s->id_pertemuan}}"><i class="fa fa-eye"></i> {{$l_s->n_pertemuan}}</a></td>
                  <?php 
                  $n_pelajaran=DB::table('matapelajaran')->where('id_matapelajaran',$l_s->id_matapelajaran)->get();
                  $j_pelajaran=count($n_pelajaran);
                  ?>
                  @if($j_pelajaran==0)
                  <td>Tidak Dipilih</td>
                  @else
                  @foreach($n_pelajaran as $pelajaran)
                  @endforeach
                  <td>{{$pelajaran->n_pelajaran}}</td>
                  @endif
                  <td>{{$l_s->tgl_pertemuan}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info"><i class="fa fa-hand-o-right"></i></button>
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="/sikupas/public/daftarpertemuan/tampil/{{$l_s->id_pertemuan}}"><i class="fa fa-eye"></i></a></li>
                        @if(Session::get('level')=="guru")
                        <li><a href="/sikupas/public/daftarpertemuan/edit/{{$l_s->id_pertemuan}}"><i class="fa fa-edit"></i></a></li>
                        <li><a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarpertemuan/delete/{{$l_s->id_pertemuan}}"><i class="fa fa-trash-o"></i></a></li>
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
                  <th>Pertemuan</th>
                  <th>Nama Pelajaran</th>
                  <th>Tanggal</th>
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