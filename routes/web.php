<?php
date_default_timezone_set('Asia/Jakarta');
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
if(empty(Session::get('level')) or Session::get('level')==""){
    return view('loginsiswa');
}elseif(!empty(Session::get('level'))){
    if(Session::get('level')=="admin"){
        return redirect(Session::get('level'));
    }elseif(Session::get('level')=="sekolah"){
        return redirect(Session::get('level'));
    }elseif(Session::get('level')=="guru"){
        return redirect(Session::get('level'));
    }elseif(Session::get('level')=="siswa"){
        return redirect(Session::get('level'));
    }
}
});
/*Route::get('/admin', function () {
    return view('loginadmin');
});
Route::get('/sekolah', function () {
    return view('dashboard');
});
Route::get('/gueu', function () {
    return view('loginguru');
});*/

//Start Modul Login Admin
Route::get('/admin', 'DashboardController@admin');
Route::get('/logout', 'LoginController@logout');
Route::post('/loginadmin','LoginController@loginadmin');
//end Modul Login Admin
//Start Modul Login Sekolah
Route::get('/sekolah', 'DashboardController@sekolah');
Route::get('/logout', 'LoginController@logout');
Route::post('/loginsekolah','LoginController@loginsekolah');
//end Modul Login Sekolah
//Start Modul Login Guru
Route::get('/guru', 'DashboardController@guru');
Route::get('/logout', 'LoginController@logout');
Route::post('/loginguru','LoginController@loginguru');
//end Modul Login Guru
//Start Modul Login Siswa
Route::get('/siswa', 'DashboardController@siswa');
Route::get('/logout', 'LoginController@logout');
Route::post('/loginsiswa','LoginController@loginsiswa');
//end Modul Login Siswa

//Start Module Daftar Sekolah
Route::get('daftarsekolah','DaftarSekolahController@lihat');
Route::get('/daftarsekolah/registrasi','DaftarSekolahController@registrasi');
Route::post('/daftarsekolah/prosesreg','DaftarSekolahController@prosesreg');
Route::get('/daftarsekolah/delete/{id}','DaftarSekolahController@delete');
Route::get('/daftarsekolah/tampil/{id}','DaftarSekolahController@tampil');
Route::get('/daftarsekolah/edit/{id}','DaftarSekolahController@edit');
Route::post('/daftarsekolah/prosesedit','DaftarSekolahController@prosesedit');
Route::post('/daftarsekolah/import', 'DaftarSekolahController@import');
//Route::post('/daftarsekolah/eksport', 'DaftarSekolahController@eksport');
//End Module Daftar Sekolah


//Start Module Daftar Guru
Route::get('daftarguru','DaftarGuruController@lihat');
Route::get('/daftarguru/registrasi','DaftarGuruController@registrasi');
Route::post('/daftarguru/prosesreg','DaftarGuruController@prosesreg');
Route::get('/daftarguru/tampil/{id}','DaftarGuruController@tampil');
Route::get('/daftarguru/edit/{id}','DaftarGuruController@edit');
Route::post('/daftarguru/prosesedit','DaftarGuruController@prosesedit');
Route::get('/daftarguru/delete/{id}','DaftarGuruController@delete');
Route::post('/daftarguru/deletcek','DaftarGuruController@deletcek');
Route::post('/daftarguru/import','DaftarGuruController@import');
//Route::post('/daftarguru/eksport', 'DaftarGuruController@eksport');
//End Module Daftar Guru


//Start Module Daftar Siswa
Route::get('daftarsiswa','DaftarSiswaController@lihat');
Route::get('/daftarsiswa/registrasi','DaftarSiswaController@registrasi');
Route::post('/daftarsiswa/prosesreg','DaftarSiswaController@prosesreg');
Route::get('/daftarsiswa/tampil/{id}','DaftarSiswaController@tampil');
Route::get('/daftarsiswa/edit/{id}','DaftarSiswaController@edit');
Route::post('/daftarsiswa/prosesedit','DaftarSiswaController@prosesedit');
Route::get('/daftarsiswa/delete/{id}','DaftarSiswaController@delete');
Route::post('/daftarsiswa/deletcek','DaftarSiswaController@deletcek');
Route::post('/daftarsiswa/import','DaftarSiswaController@import');
//Route::post('/daftarsiswa/eksport', 'DaftarSiswaController@eksport');
//End Module Daftar Siswa


//Start Module Daftar Kelas
Route::get('daftarkelas','DaftarKelasController@lihat');
Route::post('/daftarkelas/prosesreg','DaftarKelasController@prosesreg');
Route::get('/daftarkelas/tampil/{id}','DaftarKelasController@tampil');
Route::get('/daftarkelas/tampil/tambah/{id}','DaftarKelasController@tampiltambah');
Route::post('/daftarkelas/tampil/tambahproses','DaftarKelasController@tambahproses');
Route::get('/daftarkelas/tampil/deletesis/{id1}/{id}','DaftarKelasController@deletesis');
Route::get('/daftarkelas/edit/{id}','DaftarKelasController@edit');
Route::post('/daftarkelas/prosesedit','DaftarKelasController@prosesedit');
Route::get('/daftarkelas/delete/{id}','DaftarKelasController@delete');
//Route::post('/daftarkelas/import', 'DaftarKelasController@import');
//Route::post('/daftarkelas/eksport', 'DaftarKelasController@eksport');
//End Module Daftar Kelas


//Start Module Mata Pelajaran
Route::get('daftarpelajaran','DaftarPelajaranController@lihat');
Route::post('/daftarpelajaran/prosesreg','DaftarPelajaranController@prosesreg');
Route::get('/daftarpelajaran/delete/{id}','DaftarPelajaranController@delete');
Route::post('/daftarpelajaran/import','DaftarPelajaranController@import');
//End Module Mata Pelajaran


//Start Module Daftar Pertemuan
//Route::get('/daftarpertemuan','DaftarPertemuanController@sekolah');
//Route::get('/daftarpertemuan/{id1}/kelas','DaftarPertemuanController@kelas');
Route::get('/daftarpertemuan','DaftarPertemuanController@sekolah');
Route::get('/daftarpertemuan/{id1}','DaftarPertemuanController@kelas');
Route::get('/daftarpertemuan/{id1}/kelas/{id2}','DaftarPertemuanController@mapel');
Route::get('/daftarpertemuan/{id1}/kelas/{id2}/lihat/{id3}','DaftarPertemuanController@lihat');
Route::post('/daftarpertemuan/prosesreg','DaftarPertemuanController@prosesreg');
Route::get('/daftarpertemuan/tampil/{id1}','DaftarPertemuanController@tampil');
Route::get('/daftarpertemuan/edit/{id1}','DaftarPertemuanController@edit');
Route::post('/daftarpertemuan/prosesedit','DaftarPertemuanController@prosesedit');
Route::post('/daftarpertemuan/tampil/tambahmodul','DaftarPertemuanController@tambahmodul');
Route::post('/daftarpertemuan/tampil/tambahlivestream','DaftarPertemuanController@tambahlivestream');
Route::get('/daftarpertemuan/tampil/{id1}/delstream/{id2}','DaftarPertemuanController@delstream');
Route::get('/daftarpertemuan/tampil/delmodul/{id1}/{id2}','DaftarPertemuanController@delmodul');
Route::post('/daftarpertemuan/tampil/tambahtugas','DaftarPertemuanController@tambahtugas');
Route::post('/daftarpertemuan/tampil/nilai/tambahsoal','DaftarPertemuanController@tambahsoal');
Route::get('/daftarpertemuan/tampil/deltugas/{id1}/{id2}','DaftarPertemuanController@deltugas');
Route::get('/daftarpertemuan/tampil/{id1}/nilai/{id2}','DaftarPertemuanController@nilai');
Route::post('/daftarpertemuan/tampil/upjawaban','DaftarPertemuanController@upjawaban');
Route::get('/daftarpertemuan/tampil/hadirguru/{id1}/','DaftarPertemuanController@hadirguru');
Route::get('/daftarpertemuan/tampil/hadirsiswa/{id1}/{id2}','DaftarPertemuanController@hadirsiswa');
Route::get('/daftarpertemuan/tampil/{id1}/nilai/{id2}/tugas/{id3}/beri/{id4}','DaftarPertemuanController@berinilai');
Route::post('/daftarpertemuan/tampil/upnilai','DaftarPertemuanController@upnilai');\
Route::get('/daftarpertemuan/delete/{id1}','DaftarPertemuanController@delete');
Route::get('/daftarpertemuan/tampil/{id1}/nilai/{id2}/delsoal/{id3}','DaftarPertemuanController@delsoal');
//Route::post('/daftarpertemuan/import', 'DaftarPertemuanController@import');
//Route::post('/daftarpertemuan/eksport', 'DaftarPertemuanController@eksport');
//End Module Daftar Pertemuan

//start Module Cetak
Route::get('/daftarpertemuan/tampil/{id1}/absensi','CetakController@absensi');
Route::get('/daftarpertemuan/tampil/{id1}/absensi/cetak','CetakController@cetak');
Route::get('/daftarpertemuan/tampil/{id1}/nilai/{id2}/cetaknilai','CetakController@nilai');
Route::get('/daftarpertemuan/tampil/{id1}/nilai/{id2}/cetaknilai/pdf','CetakController@cetaknilai');
//End Module Cetak



