@extends('layouts.app')

@section('content')
@foreach($pertemuan as $p)
 @endforeach
    <section class="content-header">
      <h1>
        Data Pertemuan {{$p->n_pertemuan}}
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
              <h3 class="box-title">Pilih Aksi</h3>
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
          <!-- Tambah Modul -->
          <div class="modal fade" id="tambahmateri" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <?php
              if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "08:00:00")){
              ?>
              <form method="post" action="/sikupas/public/daftarpertemuan/tampil/tambahmodul" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Modul</h5>
                  </div>
                  <div class="modal-body">
       
                    {{ csrf_field() }}
                    <input type="text" hidden="hidden" name="id_pertemuan" value="{{$p->id_pertemuan}}">
                    <div class="form-group">
                        <label>Judul Modul</label>
                        <input type="text" name="n_modul" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                        <label>Link Modul</label>
                        <input type="text" name="file" class="form-control" placeholder="Enter ..." required="required">
                    </div>
       
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
                    <h3 style="text-align: center; color: red;">Maaf Penambahan Materi/Modul Dilakukan Pukul<br> 15:00:00 WIB(Sore) sampai Pukul 08:00:00 WIB(Pagi)<br>Terima Kasih</h3>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <!-- Tambah Tugas -->
          <div class="modal fade" id="tambahtugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <?php
              if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "08:00:00")){
              ?>
              <form method="post" action="/sikupas/public/daftarpertemuan/tampil/tambahtugas" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tugas</h5>
                  </div>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="text" hidden="hidden" name="id_pertemuan" value="{{$p->id_pertemuan}}">
                    <div class="form-group">
                        <label>Judul Tugas</label>
                        <input type="text" name="n_tugas" class="form-control" placeholder="Enter ..." required="required">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" placeholder="Enter ..." required="required"></textarea>
                    </div>
                    {{--<!--div class="form-group">
                      <label>Foto Tugas</label>
                      <input type="file" accept="image/*;capture=camera" name="file" class="form-control" placeholder="Enter ...">
                    </div-->--}}
                    <div class="form-group">
                        <label>Link Tugas</label>
                        <input type="text" name="linktugas" class="form-control" placeholder="Enter ...">
                    </div>
                    <div class="form-group">
                        <label>Terakhir dikumpul</label>
                        <input type="date" name="tgl" class="form-control" placeholder="Enter ..." required="required">
                        <input type="time" name="jam" class="form-control" placeholder="Enter ..." required="required">
                    </div>
       
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
                    <h3 style="text-align: center; color: red;">Maaf Penambahan Tugas Dilakukan Pukul<br> 15:00:00 WIB(Sore) sampai Pukul 08:00:00 WIB(Pagi)<br>Terima Kasih</h3>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <!-- Tambah FB Live Stream -->
          <div class="modal fade" id="tambahfbstream" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="/sikupas/public/daftarpertemuan/tampil/tambahlivestream">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Embed FB Live Stream</h5>
                  </div>
                  <div class="modal-body">
       
                    {{ csrf_field() }}
                    <input type="text" hidden="hidden" name="id_pertemuan" value="{{$p->id_pertemuan}}">
                    <div class="form-group">
                        <label>Embed Live Stream Facebook</label>
                        <textarea name="fb_livestream" class="form-control" placeholder="Enter ..." required="required"></textarea>
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
          <!-- Lihat Absensi Siswa -->
          <div class="modal fade" id="absensiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="/sikupas/public/daftarsekolah/import" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar Absensi</h5>
                  </div>
                  <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php $i=1 @endphp
                      @foreach($daftarhadir as $l_s)
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$l_s->n_siswa}}</td>
                        <td>{{$l_s->j_kelamin}}</td>
                        <td>{{$l_s->agama}}</td>
                        <td>@if($l_s->a_siswa=="Hadir") <i class="fa fa-calendar-check-o"></i> Hadir @else <i class="fa fa-calendar-times-o"></i> Absen @endif</td>
                      </tr>
                      @endforeach             
                      </tbody>
                      <tfoot>
                      <tr>
                      <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Statu</th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div class="modal-footer">
                  @if((Session::get('level')=="guru" or Session::get('level')=="sekolah" or Session::get('level')=="admin"))
                    <a href="/sikupas/public/daftarpertemuan/tampil/{{$p->id_pertemuan}}/absensi" target="_target" class="btn btn-success my-3" target="_blank"><i class="fa fa-print"></i> Absen</a>
                  @elseif((Session::get('level')=="guru" or Session::get('level')=="sekolah" or Session::get('level')=="admin") and date('H:i:s')>"15:00:00")
                  Cetak tersedia Pukul 15:00:00 WIB
                  @endif 
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- Chat -->
          <div class="modal fade" id="chat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chat Tanya Jawab</h5>
                  </div>
                  <div class="box-body chat" id="chat-box">
                  @foreach($chat as $c)
                  <div class="timeline-item" id="chatku">
                    <h5 class="timeline-header">{{$c->n_pengirim}}</h5>
                    <span class="time"><i class="fa fa-clock-o"></i> {{$c->tgl}}</span>
                    <div class="timeline-body">
                    {{$c->isi}}
                    </div>
                  </div>
                  <hr>
                  @endforeach
                  </div>
                  <form method="get" action="/sikupas/public/daftarpertemuan/tampil/{{$p->id_pertemuan}}">
                  <div class="box-footer">
                    <div class="input-group">
                      <input name="isi" class="form-control" placeholder="Type message...">

                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                      </div>
                    </div>
                  </div>
                  </form>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
          </div>
          <!--a href="/cabdissunggal/public/daftarkelas/tampil/tambah/{{$p->id_kelas}}" class="btn btn-success my-3"><i class="fa fa-plus"></i> Materi</a-->
          @if(Session::get('level')=="guru")
          <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#tambahmateri">
          <i class="fa fa-plus"></i> Materi
          </button>
          <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#tambahtugas">
          <i class="fa fa-plus"></i> Tugas
          </button>
          <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#tambahfbstream">
          <i class="fa fa-plus"></i> FB Stream
          </button>
          @endif
          <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#absensiswa">
          <i class="fa fa-eye"></i> Absensi
          </button>
          <button type="button" class="btn btn-success mr-5" data-toggle="modal" data-target="#chat" onclick="reloadDIV ();">
          <i class="fa fa-whatsapp"></i> Diskusi
          </button>
          @if(Session::get('level')=="guru")
	          @if($p->tgl_pertemuan == date('Y-m-d'))
	            @if($p->a_guru=="Hadir")
	            <b class="btn btn-success mr-5"><i class="fa fa-check"></i> Sudah Di Mulai</b>
	            @else
	            <a href="/sikupas/public/daftarpertemuan/tampil/hadirguru/{{$p->id_pertemuan}}" class="btn btn-success mr-5"><i class="fa fa-hand-stop-o"></i></a>
	            @endif
	          @elseif($p->tgl_pertemuan <= date('Y-m-d'))
	          	<b class="btn btn-success mr-5"><i class="fa fa-ban"></i> Terlewat</b>
	          @else
	          	<b class="btn btn-success mr-5"><i class="fa fa-ban"></i> Mulai {{$p->tgl_pertemuan}}</b>
	          @endif
          @endif
          @foreach($pertemuankelas as $p_k2)
          @endforeach
          @if(Session::get('level')=="siswa")
          	@if($p->tgl_pertemuan == date('Y-m-d'))
	            @if($p_k2->a_siswa=="Hadir")
	              <b class="btn btn-success mr-5"><i class="fa fa-check"></i> Kamu Hadir</b>
	            @else
	              @if($p->a_guru=="Hadir")
	              <a href="/sikupas/public/daftarpertemuan/tampil/hadirsiswa/{{$p->id_pertemuan}}/{{Session::get('id')}}/" class="btn btn-success mr-5"><i class="fa fa-hand-stop-o"></i></a>
	              @else 
	              <b class="btn btn-success mr-5"><i class="fa fa-ban"></i> Belum Dimulai</b> 
	              @endif
	            @endif
            @elseif($p->tgl_pertemuan <= date('Y-m-d'))
	          	<b class="btn btn-success mr-5"><i class="fa fa-ban"></i> Absen</b>
	          @else
	          	<b class="btn btn-success mr-5"><i class="fa fa-ban"></i> Mulai {{$p->tgl_pertemuan}}</b>
	          @endif
          @endif
          </div>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Info Pertemuan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Tanggal Pertemuan</strong>
              <p class="text-muted">{{$p->tgl_pertemuan}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Status</strong>
              <p class="text-muted">@if($p->a_guru=="Hadir") Mulai @else Belum Di Mulai @endif</p>
              <strong><i class="fa fa-book margin-r-5"></i> Mata Pelajaran</strong>
              <?php 
              $n_pelajaran=DB::table('matapelajaran')->where('id_matapelajaran',$p->id_matapelajaran)->get();
              $j_pelajaran=count($n_pelajaran);
              ?>
              @if($j_pelajaran==0)
              <p class="text-muted">Nama Pelajaran Belum dipilih</p>
              @else
               @foreach($n_pelajaran as $pelajaran)
               @endforeach
              <p class="text-muted">{{$pelajaran->n_pelajaran}}</p>
              @endif
              <strong><i class="fa fa-book margin-r-5"></i> Judul Pertemuan</strong>
              <p class="text-muted">{{$p->n_pertemuan}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Nama Guru</strong>
              <p class="text-muted">{{$p->n_guru}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Kelas/Jurusan</strong>
              <p class="text-muted">{{$p->n_kelas}}</p>
              <strong><i class="fa fa-user margin-r-5"></i>Wali Kelas</strong>
              <p class="text-muted">{{$p->n_w_kelas}}</p>
            @if((Session::get('level')=="guru" or Session::get('level')=="sekolah"or Session::get('level')=="admin") or ($p_k2->a_siswa=="Hadir" and Session::get('level')=="siswa"))
              <hr>
              <strong><i class="fa fa-download margin-r-5"></i>Download Modul</strong>
              @if(!empty($modulpertemuan))
              @foreach($modulpertemuan as $t_m)
              <p class="text-muted">
                <a href="{{$t_m->file}}" target="_blank" class="margin-r-5 margin-l-5">
                	<i class="fa fa-download margin-r-5"></i> {{$t_m->n_modul}}</a> 
                	@if(Session::get('level')=="guru")
                	<a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarpertemuan/tampil/delmodul/{{$t_m->id_modul}}/{{$t_m->id_pertemuan}}" class="margin-r-5 margin-l-5"><i class="fa fa-close margin-r-5"></i></a>@endif
              </p>
              @endforeach
              @endif
              @if(!empty($tugaspertemuan))
              <hr>
              <strong><i class="fa fa-book margin-r-5"></i>Daftar Tugas</strong>
              @foreach($tugaspertemuan as $t_t)
              <p class="text-muted">
                <a href="/sikupas/public/daftarpertemuan/tampil/{{$t_t->id_pertemuan}}/nilai/{{$t_t->id_tugaspertemuan}}/" class="margin-r-5 margin-l-5" target="_blank">
                <i class="fa fa-eye margin-r-5"></i> {{$t_t->n_tugas}}</a>  
                @if(Session::get('level')=="guru")
                <a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarpertemuan/tampil/deltugas/{{$t_t->id_tugaspertemuan}}/{{$t_t->id_pertemuan}}" class="margin-r-5 margin-l-5"><i class="fa fa-close margin-r-5"></i></a> @endif
              </p>
              @endforeach
              @endif
            </div>
            <!-- /.box-footer-->
          </div>          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- video Pembelajaran -->
    @php $c_stream=count($livestream) @endphp
    @if($c_stream>0)
    @foreach($livestream as $stream)
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <h3 class="timeline-header">Facebook Live Streaming 
            @if(Session::get('level')=="guru")
            <a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/sikupas/public/daftarpertemuan/tampil/{{$stream->id_pertemuan}}/delstream/{{$stream->id_livestreampertemuan}}" class="margin-r-5 margin-l-5">
            <i class="fa fa-close margin-r-5"></i>
            </a>
            @endif</h3>
            <div class="embed-responsive embed-responsive-16by9">
            <?php echo $stream->embed;?> 
            </div>
            <!-- /.box -->
        </div>
          <!-- /.col -->
      </div>
        <!-- /.row -->
    </section>
    @endforeach
    @endif
    <!-- video Pembelajaran -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
          <h3 class="timeline-header">Video Pembelajaran</h3>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$p->l_v_pembelajaran}}" frameborder="0" allowfullscreen></iframe>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
            @elseif(Session::get('level')=="siswa" and ($p_k2->a_siswa!="Hadir" and $p->a_guru=="Hadir"))
              <hr>
              <strong><i class="fa fa-download margin-r-5"></i>Kamu Belum Absen</strong>
            @elseif(Session::get('level')=="siswa" and ($p_k2->a_siswa!="Hadir" and $p->a_guru!="Hadir"))
              <hr>
              <strong><i class="fa fa-download margin-r-5"></i>Belum Dimulai</strong>
            @endif
@endsection