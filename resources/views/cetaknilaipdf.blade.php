<?php
if((date("H:i:s") >= "15:00:00" and date("H:i:s") <= "24:00:00") or (date("H:i:s") >= "00:00:00" and date("H:i:s") <= "07:00:00")){
?>
<html>
<head>
	<title>Laporan Absensi {{Session::get('a_sekolah')}}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
@foreach($pertemuan as $p)
@endforeach
@foreach($tugaspertemuan as $t_p)
@endforeach
		<table align="center" style="width:90%">
		<thead>
			<tr align="center">
				<td width="20%"><img src="{{url('logo-sumutprov.png')}}" style="width: 100px;"></td>
				<td width="50%">
					<h4>Daftar Nilai E-Learning <br>{{Session::get('name1')}}</h4>
					<h5>Cabang Dinas Pendidikan Sunggal</h5>
					<h5>Provinsi Sumatera Utara</h5>
				</td>
				<td width="20%"><img src="{{url('tutwurihandayani.png')}}" style="width: 180px;"></td>
			</tr>
		</thead>
		</table>
		<br>
		<table align="center" style="width:90%">
			<tr align="left">
				<td style="width:25%">Nama Pertemuan</td>
				<td style="width:1%">:</td>
				<td style="width:64%">{{$p->n_pertemuan}}</td>
			</tr>
			<tr align="left">
				<td>Tanggal Pertemuan</td>
				<td>:</td>
				<td>{{$p->tgl_pertemuan}}</td>
			</tr>
			<tr align="left">
				<td>Nama Pelajaran</td>
				<td>:</td>
				<?php $pel=DB::table('matapelajaran')->where('id_matapelajaran',$p->id_matapelajaran)->get()?>
				@foreach($pel as $ajar)
				<td>{{$ajar->n_pelajaran}}</td>
				@endforeach
			</tr>
			<tr align="left">
				<td>Nama Guru</td>
				<td>:</td>
				<td>{{$p->n_guru}}</td>
			</tr>
			<tr align="left">
				<td>Kelas</td>
				<td>:</td>
				<td>{{$p->n_kelas}}</td>
			</tr>
			<tr align="left">
				<td>Wali Kelas</td>
				<td>:</td>
				<td>{{$p->n_w_kelas}}</td>
			</tr>
			<tr align="left">
				<td style="width:20%">Nama Tugas</td>
				<td style="width:1%">:</td>
				<td style="width:69%">{{$t_p->n_tugas}}</td>
			</tr>
			<tr align="left">
				<td>Terakhir Dikumpul</td>
				<td>:</td>
				<td>{{$t_p->tgl_kumpul}}</td>
			</tr>
		</table>
		<br>
		<table style="width:90%" class='table table-bordered' align="center">
			<thead>
				<tr>
					<th style="width:5%; text-align:center; vertical-align: center;">No</th>
					<th style="width:45%; text-align:center; vertical-align: center;">Nama Siswa</th>
					<th style="width:15%; text-align:center; vertical-align: center;">Tanggal Kumpul</th>
					<th style="width:10%; text-align:center; vertical-align: center;">Jam Kumpul</th>
					<th style="width:15%; text-align:center; vertical-align: center;">Nilai</th>
				</tr>
			</thead>
			<tbody>
			@php $i=1 @endphp
			@foreach($pertemuankelas as $k_p)
				<tr align="center">
					<td>{{$i++}}</td>
					<td>{{$k_p->n_siswa}}</td>
                    <?php
                    $nilaipertemuan2= DB::table('nilaipertemuan')->where('id_siswa','=',$k_p->id_siswa)->where('id_pertemuan','=',$p->id_pertemuan)->where('id_tugaspertemuan','=',$t_p->id_tugaspertemuan)->get();
                    ?>
                    @foreach($nilaipertemuan2 as $t_n)
                    @endforeach
					<?php $t_per=explode(' ',$t_n->tgl_jawab); ?>
					<td>{{$t_per['0']}}</td>
					<td>{{$t_per['1']}}</td>
					<td>
                    @if($t_n->nilai=="Kosong")
                        0
                    @else
                        {{$t_n->nilai}}
                    @endif
                    </td>
				</tr>
			@endforeach
			</tbody>
		</table>
</body>
</html>
<?php
}else{
?>
<div class="modal-content">
<div class="form-group">
<h3 style="text-align: center; color: red;">Maaf Cetak Nilai Dilakukan Pukul<br> 15:00:00 WIB(Sore) sampai Pukul 07:00:00 WIB(Pagi)<br>Terima Kasih</h3>
</div>
</div>
<?php } ?>