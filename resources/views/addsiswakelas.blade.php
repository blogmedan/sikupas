@extends('layouts.app')

@section('content')

    <section class="content-header">
      <h1>
        Data Siswa
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Siswa</li>
      </ol>
      <!-- /.row -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pilih Siswa</h3>
            </div>
            <?php
            if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "07:00:00")){
            ?>
            <form role="form" method="POST" action="{{url('daftarkelas/tampil/tambahproses')}}">
            <input type="submit" class="btn btn-success my-3" name="tambah" value="+ Siswa">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>NISN</th>
                  <th>Nama Siswa</th>
                  <th>Tgl Lahir</th>
                  <th>Jenis Kelamin</th>
                  <th>Kelas</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($siswa as $l_s)
                <tr>                
                @foreach($kelas as $p)                
                @endforeach
                {{ csrf_field() }} 
                <td>
                <input type="text" name="id_kelas" value="{{$p->id_kelas}}" hidden="hidden">
                <input type="checkbox" name="id_siswa[]" value="{{$l_s->id_siswa}}">
                </td>
                  <td>{{$l_s->nisn}}</td>
                  <td>{{$l_s->nama}}</td>
                  <td>{{$l_s->tgl_lahir}}</td>
                  <td>{{$l_s->j_kelamin}}</td>
                  <td>{{$l_s->kelas}}</td>
                </tr>
                @endforeach    
                </form>
            <?php
            }else{
            ?>
              <div class="modal-content">
                <div class="form-group">
                  <h3 style="text-align: center; color: red;">Maaf Akses Dibuka Pukul<br> 15:00:00 WIB(Sore) sampai Pukul 07:00:00 WIB(Pagi)<br>Terima Kasih</h3>
                </div>
              </div>
            <?php } ?>       
                </tbody>
                <tfoot>
                <tr>
                  <th>#</th>
                  <th>NISN</th>
                  <th>Nama Siswa</th>
                  <th>Tgl Lahir</th>
                  <th>Jenis Kelamin</th>
                  <th>Agama</th>
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