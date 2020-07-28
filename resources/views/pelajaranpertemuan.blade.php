@extends('layouts.app')

@section('content')

    <section class="content-header">
      <h1>
        Data Pertemuan
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
                <h3 class="box-title">Daftar Pertemuan</h3>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pilih Pelajaran</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Pelajaran</th>
                  <th>Jumlah Pertemuan</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($matapelajaran as $p)
                @foreach($kelas as $k)
                @endforeach
                <?php 
                if(Session::get('level')=="guru"){
                  $j_pertemuan = DB::table('pertemuan')->where('id_sekolah',$p->id_sekolah)->where('id_kelas',$k->id_kelas)->where('id_guru',Session::get('id'))->where('id_matapelajaran',$p->id_matapelajaran)->count();
                }elseif(Session::get('level')=="siswa"){
                  $j_pertemuan = DB::table('pertemuan')->where('id_sekolah',$p->id_sekolah)->where('id_kelas',$k->id_kelas)->where('id_matapelajaran',$p->id_matapelajaran)->count();
                }else{
                  $j_pertemuan = DB::table('pertemuan')->where('id_sekolah',$p->id_sekolah)->where('id_kelas',$k->id_kelas)->where('id_matapelajaran',$p->id_matapelajaran)->count();
                }
                ?>
                @if($j_pertemuan>0)
                <tr>
                  <td>{{$i++}}</td>
                  <td>
                  <a href="/sikupas/public/daftarpertemuan/{{$p->id_sekolah}}/kelas/{{$k->id_kelas}}/lihat/{{$p->id_matapelajaran}}">
                  {{$p->n_pelajaran}}
                  </a>
                  </td>
                  <td>{{$j_pertemuan}}</td>
                </tr>
                @endif
                @endforeach       
                </tbody>
                <tfoot>
                <tr>
                  <th>#</th>
                  <th>Nama Pelajaran</th>
                  <th>Jumlah Pertemuan</th>
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