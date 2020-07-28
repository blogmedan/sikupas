@extends('layouts.app')

@section('content')
    <section class="content-header">
      <h1>
        Berikan Nilai
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Penilaian</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="box">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Masukkan Nilai</h3>
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
              <?php
              if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "07:00:00")){
              ?>
              <form method="post" action="/sikupas/public/daftarpertemuan/tampil/upnilai" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Beri Nilai</h5>
                    </div>
                    <div class="modal-body">
                    @foreach($pertemuan as $p)
                    @endforeach
                    @foreach($pertemuankelas as $s)
                    @endforeach
                    @foreach($tugaspertemuan as $t_p)
                    @endforeach
                    @foreach($nilaipertemuan as $n_p)
                    @endforeach
                    {{ csrf_field() }}
                    <input type="text" hidden="hidden" name="id_nilaipertemuan" value="{{$n_p->id_nilaipertemuan}}">
                    <input type="text" hidden="hidden" name="id_tugaspertemuan" value="{{$t_p->id_tugaspertemuan}}">
                    <input type="text" hidden="hidden" name="id_pertemuan" value="{{$p->id_pertemuan}}">
                    <input type="text" hidden="hidden" name="id_siswa" value="{{$s->id_siswa}}">
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <p>{{$s->n_siswa}}</p>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <p>{{$p->n_kelas}}</p>
                    </div>
                    <div class="form-group">
                        <label>Nama Guru</label>
                        <p>{{$p->n_guru}}</p>
                    </div>
                    <div class="form-group">
                        <label>Judul Tugas</label>
                        <p>{{$t_p->n_tugas}}</p>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Tugas</label>
                        <p>{{$t_p->deskripsi}}</p>
                    </div>
                    <div class="form-group">
                        <label>Foto Tugas</label>
                        <p>
                        @if($t_p->f_tugas=="Kosong")
                        Kosong
                        @else
                        <img class="img-responsive" src="{{url('soal/'.$t_p->f_tugas)}}" alt="Photo">
                        @endif
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Link Tugas</label>
                        <p>
                        @if($t_p->linktugas=="Kosong")
                        Kosong
                        @else
                        <a target="_blank" href="{{$t_p->linktugas}}">{{$t_p->linktugas}}</a>
                        @endif
                        </p>
                    </div>
                    @if(Session::get('level')=="guru" or (Session::get('level')=="siswa" and $s->id_siswa==Session::get('id')))
                    <div>
                    <label>Jawaban</label>
                    <p>
                    @if($n_p->s_jawaban=="Belum")
                    Belum Di Jawab
                    @else
                    {{$n_p->jawaban}}
                    @endif
                    </p>
                    </div>
                    <div>
                    <label>Foto Jawaban</label>
                    <p>
                    @if($n_p->file=="Kosong")
                    Tidak Ada
                    @else
                        <img class="img-responsive" src="{{url('tugas/'.$n_p->file)}}" alt="Photo">
                    @endif
                    </p>
                    </div>
                    <div class="form-group">
                      <label>Link Jawaban</label>
                      <p>
                      @if($n_p->linkjawaban=="Kosong")
                      Tidak Ada
                      @else
                      <a target="_blank" href="{{$n_p->linkjawaban}}">Lihat Jawaban</a>
                      @endif
                      </p>
                    </div>
                    <div class="form-group">
                      <strong><i class="fa fa-book margin-r-5"></i> Daftar Soal Esai</strong>
                      <p class="text-muted">
                      <h4>
                      <ol>
                      @foreach($soalnilaipertemuan as $s)
                        <li>{{$s->soal}}
                        <?php $jawab=DB::table('jawabannilaipertemuan')->where('id_soalnilaipertemuan',$s->id_soalnilaipertemuan)->where('id_siswa',$n_p->id_siswa)->get();?>
                        @foreach($jawab as $j)
                        @endforeach
                        <p><label>Jawaban</label><p>
                        <p>{{$j->jawaban}}</p>
                        </li>
                      @endforeach
                      <ol>
                      </h4>
                      </p>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Nilai</label>
                        @if(Session::get('level')=="guru")
                        <input type="text" name="nilai" required="required" class="form-control" value="{{$n_p->nilai}}" placeholder="Enter ...">
                        @else
                        <p>{{$n_p->nilai}}</p>
                        @endif
                    </div>
                    @if(Session::get('level')=="guru")
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" name="beri" value="Beri Nilai">
                    </div>
                    @endif
                </div>
              </form>
              <?php
              }else{
              ?>
                <div class="modal-content">
                  <div class="form-group">
                    <h3 style="text-align: center; color: red;">Maaf Penilaian Tugas Dilakukan Pukul<br> 15:00:00 WIB(Sore) sampai Pukul 07:00:00 WIB(Pagi)<br>Terima Kasih</h3>
                  </div>
                </div>
              <?php } ?>
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