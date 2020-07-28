<?php

namespace App\Imports;

use App\Siswa;
use Crypt;
use Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class SiswaImport implements ToModel, WithHeadingRow // USE CLASS YANG DIIMPORT
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $c_user=DB::table('siswa')->where('username',$row['username'])->count();
        if($c_user<1){
        return new Siswa([
            'id_sekolah' => Session::get('id_sekolah'),
            'nisn' => $row['nisn'],
            'nama' => $row['nama'], 
            'agama' => $row['agama'],
            'j_kelamin' => $row['jenis_kelamin'],
            't_lahir' => $row['tempat_lahir'],
            'tgl_lahir' => $row['tgl_lahir'],
            'a_sekolah' => Session::get('name'),
            'username' => $row['username'],
            'password' => Crypt::encrypt($row['password']),
            'email' => $row['email'],
        ]);
        }else{
            //$pesan=array('Data Username Siswa '.$row['username'].' Sudah Terdaftar!');
            Session::flash('gagal','Data Username Siswa '.$row['username'].' Sudah Terdaftar!');
            //return redirect('daftarsiswa');
        }
    }
}
