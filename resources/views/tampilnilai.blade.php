@extends('layouts.app')

@section('content')

    <section class="content-header">
      <h1>
        Data Penilaian
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Penilaian</li>
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
          @foreach($pertemuan as $p)
          @endforeach
          @foreach($tugaspertemuan as $t_p)
          @endforeach
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
          </div>
          @if(Session::get('level')=="guru")
          <div class="modal fade" id="tambahsoal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <?php
              if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "07:00:00")){
              ?>
              <form method="post" action="/sikupas/public/daftarpertemuan/tampil/nilai/tambahsoal">
              {{ csrf_field() }}
              <input type="text" hidden="hidden" value="{{$t_p->id_tugaspertemuan}}" name="id_tugaspertemuan" />
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Soal</h5>
                    </div>                    
                    <div class="modal-body">
                    <div class="form-group">
                    <label>Tuliskan Soal</label>
                    <textarea name="soal" class="form-control" placeholder="Enter ..." required="required"></textarea>
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
                    <h3 style="text-align: center; color: red;">Maaf Penambahan Soal Dilakukan Pukul<br> 15:00:00 WIB(Sore) sampai Pukul 07:00:00 WIB(Pagi)<br>Terima Kasih</h3>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="modal fade" id="uploadsoal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="post" action="/sikupas/public/daftarpertemuan/tampil/{{$p->id_pertemuan}}/nilai/{{$t_p->id_tugaspertemuan}}/tambahsoal" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="text" hidden="hidden" value="$t_p->id_tugaspertemuan" name="id_tugaspertemuan" />
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Soal</h5>
                    </div>                    
                    <div class="modal-body">
                    <div class="form-group">
                    <label>Pilih file excel</label>
                    <div class="form-group">
                      <input type="file" name="file" required="required">
                    </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="upload" value="Upload">
                    </div>
                </div>
              </form>
            </div>
          </div>
          @endif
          @if(Session::get('level')=="guru")
          <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#tambahsoal">
          <i class="fa fa-plus"></i> Soal
          </button>
          <!--button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#uploadsoal">
          <i class="fa fa-upload"></i> Soal
          </button>
          <a href="{{url('templateguru.xlsx')}}" class="btn btn-success my-3" target="_blank"><i class="fa fa-download"></i> TEMPLATE</a-->
          @endif
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Info Tugas</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Terakhir Dikumpul</strong>
              <p class="text-muted" style="color:red;">{{$t_p->tgl_kumpul}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Mata Pelajaran</strong>
              <?php 
              $n_pelajaran=DB::table('matapelajaran')->where('id_matapelajaran',$p->id_matapelajaran)->get();
              ?>
              @foreach($n_pelajaran as $pelajaran)
              @endforeach
              <p class="text-muted">{{$pelajaran->n_pelajaran}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Judul Pertemuan</strong>
              <p class="text-muted">{{$p->n_pertemuan}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Nama Guru</strong>
              <p class="text-muted">{{$p->n_guru}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Kelas/Jurusan</strong>
              <p class="text-muted">{{$p->n_kelas}}</p>
              <strong><i class="fa fa-user margin-r-5"></i>Wali Kelas</strong>
              <p class="text-muted">{{$p->n_w_kelas}}</p>
              <hr>
              <strong><i class="fa fa-download margin-r-5"></i>Download Modul</strong>
              @if(!empty($modulpertemuan))
              @foreach($modulpertemuan as $t_m)
              <p class="text-muted">
                <a href="{{$t_m->file}}" target="_blank" class="margin-r-5 margin-l-5">
                  <i class="fa fa-download margin-r-5"></i> {{$t_m->n_modul}}</a> @if(Session::get('level')=="guru")
                  <a data-target="#konfirmasi_hapus" data-toggle='modal' data-href="/cabdissunggal/public/daftarpertemuan/tampil/delmodul/{{$t_m->id_modul}}/{{$t_m->id_pertemuan}}" class="margin-r-5 margin-l-5"><i class="fa fa-close margin-r-5"></i></a> @endif
              </p>
              @endforeach
              @endif
            </div>
            <!-- /.box-footer-->
            <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Soal</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Judul Tugas</strong>
              <p class="text-muted">{{$t_p->n_tugas}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Deskripsi Tugas</strong>
              <p class="text-muted">{{$t_p->deskripsi}}</p>
              <strong><i class="fa fa-book margin-r-5"></i> Foto Tugas</strong>
              <p class="text-muted">
              @if($t_p->f_tugas=="Kosong")
                Tidak Ada
              @else
              <img class="img-responsive" src="{{url('soal/'.$t_p->f_tugas)}}" alt="Photo">
              @endif
              </p>
              <strong><i class="fa fa-book margin-r-5"></i> Link Tugas</strong>
              <p class="text-muted">
              @if($t_p->linktugas!="Kosong")
              <a href="{{$t_p->linktugas}}" target="_blank">{{$t_p->n_tugas}}</a>
              @else
              Tidak Ada
              @endif
              </p>
              <strong><i class="fa fa-book margin-r-5"></i> Daftar Soal Esai</strong>
              <p class="text-muted">
              <h4>
              <ol>
              @foreach($soalnilaipertemuan as $s)
                <li>{{$s->soal}}
                @if(Session::get('level')=="guru")
                <a data-target="#konfirmasi_hapus" data-toggle='modal' 
                data-href="/sikupas/public/daftarpertemuan/tampil/{{$s->id_pertemuan}}/nilai/{{$s->id_tugaspertemuan}}/delsoal/{{$s->id_soalnilaipertemuan}}" 
                class="margin-r-5 margin-l-5">
                <i class="fa fa-close margin-r-5"></i></a>
                @endif
                </li>
              @endforeach
              <ol>
              </h4>
              </p>
            </div>
            <div class="box">
            @foreach($nilaipertemuan as $n_p)
            @endforeach
            @if(Session::get('level')=="siswa")
            <div class="box-header with-border">
              <h3 class="box-title">Masukkan Jawaban</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            @if($n_p->s_jawaban=="Belum")
            <div class="box-body">
            <?php
            if($t_p->tgl_kumpul >= date('Y-m-d H:i:s')){
                        ?>
              <form role="form" action="{{url('daftarpertemuan/tampil/upjawaban')}}" enctype="multipart/form-data" method="post">
                <!-- text input -->
                {{ csrf_field() }}
                <input type="text" hidden="hidden" name="id_nilaipertemuan" value="{{$n_p->id_nilaipertemuan}}">
                <input type="text" hidden="hidden" name="id_tugaspertemuan" value="{{$n_p->id_tugaspertemuan}}">
                <input type="text" hidden="hidden" name="id_pertemuan" value="{{$n_p->id_pertemuan}}">
                <input type="text" hidden="hidden" name="id_siswa" value="{{Session::get('id')}}">

                <div class="form-group">
                  <label>Deskripsi Jawaban</label>
                  <textarea name="jawaban" class="form-control" placeholder="Enter ..." required="required"></textarea>
                </div>
                {{--<!--div class="form-group">
                  <label>Foto Jawaban</label>
                  <input type="file" accept="image/*;capture=camera" name="file" class="form-control" placeholder="Enter ...">
                </div-->--}}
                <div class="form-group">
                  <label>Link Jawaban</label>
                  <input type="text" name="linkjawaban" class="form-control" placeholder="Enter ...">
                </div>
                <strong><i class="fa fa-book margin-r-5"></i> Daftar Soal Esai</strong>
                <p class="text-muted">
                <h4>
                <ol>
                @foreach($soalnilaipertemuan as $s)
                  <li><label>{{$s->soal}}</label>
                  @if(Session::get('level')=="guru")
                  <a data-target="#konfirmasi_hapus" data-toggle='modal' 
                  data-href="/sikupas/public/daftarpertemuan/tampil/{{$s->id_pertemuan}}/nilai/{{$s->id_tugaspertemuan}}/delsoal/{{$s->id_soalnilaipertemuan}}" 
                  class="margin-r-5 margin-l-5">
                  <i class="fa fa-close margin-r-5"></i></a>
                  @endif
                  </li>
                  <div class="form-group">
                  <label>Jawab</label>
                  <?php $jawab=DB::table('jawabannilaipertemuan')->where('id_soalnilaipertemuan',$s->id_soalnilaipertemuan)->get();?>
                  @foreach($jawab as $j)
                  @endforeach
                  <input type="text" name="id_soalnilaipertemuan[]" value="{{$s->id_soalnilaipertemuan}}" hidden="hidden">
                  <textarea name="esai[]" class="form-control" placeholder="Masukkan Jawaban ..." required="required">{{$j->jawaban}}</textarea>
                </div>
                @endforeach
                <ol>
                </h4>
                </p>
                <div class="box-footer">
                  <input type="submit" class="btn btn-primary" name="jawab" value="Jawab">
                </div>
            </form>
            
                        <?php
            }else{
              ?>
              <div class="box-body">
                <div class="form-group">
                    <label>Maaf Waktu Menjawab Kamu Sudah Habis!! <br> Perhatikan Batas Waktu Menjawab!!</label>
                </div>
              </div>
              <?php
            }
            ?>
            @else
            Sudah Dijawab
            @endif
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
              <div class="modal-content">
                  <div class="modal-header">
                  @if((Session::get('level')=="guru" or Session::get('level')=="sekolah" or Session::get('level')=="admin"))
                    <a href="/sikupas/public/daftarpertemuan/tampil/{{$p->id_pertemuan}}/nilai/{{$t_p->id_tugaspertemuan}}/cetaknilai" class="btn btn-success my-3" target="_blank">
                    <i class="fa fa-print"></i> Nilai</a><br>
                  @elseif((Session::get('level')=="guru" or Session::get('level')=="sekolah" or Session::get('level')=="admin") and date('H:i:s')>"15:00:00")
                  Cetak tersedia Pukul 15:00:00 WIB
                  @endif
                      <h5 class="modal-title" id="exampleModalLabel">Daftar Nilai</h5>
                  </div>
                  <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Nilai</th>
                        <!--th>Aksi</th-->
                      </tr>
                      </thead>
                      <tbody>
                      @php $i=1 @endphp
                      @foreach($pertemuankelas as $l_s)
                      <tr>
                        <td>{{$i++}}</td>
                        <td><a href="/sikupas/public/daftarpertemuan/tampil/{{$n_p->id_pertemuan}}/nilai/{{$n_p->id_nilaipertemuan}}/tugas/{{$t_p->id_tugaspertemuan}}/beri/{{$l_s->id_siswa}}">
                          <i class="fa fa-eye"></i> {{$l_s->n_siswa}}</a></td>
                        <td>{{$l_s->j_kelamin}}</td>
                        <td>{{$l_s->agama}}</td>
                        <td>
                        <?php
                          $nilaipertemuan2= DB::table('nilaipertemuan')->where('id_siswa','=',$l_s->id_siswa)->where('id_pertemuan','=',$p->id_pertemuan)->where('id_tugaspertemuan','=',$t_p->id_tugaspertemuan)->get();
                        ?>
                        @foreach($nilaipertemuan2 as $t_n)
                        @endforeach
                        @if($t_n->nilai=="Kosong")
                          Belum di Nilai
                        @else
                        {{$t_n->nilai}}
                        @endif
                        </td>
                        <!--td>
                        @if(Session::get('level')=="guru")
                          <a href="/sikupas/public/daftarpertemuan/tampil/{{$n_p->id_pertemuan}}/nilai/{{$n_p->id_nilaipertemuan}}/tugas/{{$t_p->id_tugaspertemuan}}/beri/{{$l_s->id_siswa}}" class="btn btn-success my-3">
                          <i class="fa fa-edit"></i></a>           
                        @endif
                        @if(Session::get('level')=="siswa")
                          <a href="/sikupas/public/daftarpertemuan/tampil/{{$n_p->id_pertemuan}}/nilai/{{$n_p->id_nilaipertemuan}}/tugas/{{$t_p->id_tugaspertemuan}}/beri/{{$l_s->id_siswa}}" class="btn btn-success my-3">
                          <i class="fa fa-eye"></i></a>           
                        @endif
                        </td-->
                      </tr>
                      @endforeach     
                      </tbody>
                      <tfoot>
                      <tr>
                      <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Nilai</th>
                        <!--th>Aksi</th-->
                      </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
@endsection