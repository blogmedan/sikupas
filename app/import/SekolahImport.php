<?php

namespace App\Imports;

use App\Sekolah;
use Session;
use Crypt;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class SekolahImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $c_user=DB::table('sekolah')->where('username',$row['username'])->count();
        if($c_user<1){
        return new Sekolah([
            'npsn' => $row['npsn'],
            'status' => $row['status'],
            'n_sekolah' => $row['nama_sekolah'], 
            'n_k_sekolah' => $row['nama_kepala_sekolah'],
            'username' => $row['username'],
            'password' => Crypt::encrypt($row['password']),
        ]);
        }else{
            Session::flash('gagal','Data Username Guru '.$row['username'].' Sudah Terdaftar!');
        }
    }
}

/*class SekolahImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /*public function model(array $row)
    {
         return new Sekolah([
            'status' => $row[1],
            'n_sekolah' => $row[2], 
            'n_k_sekolah' => $row[3],
            'username' => $row[4],
            'password' => Crypt::encrypt($row[5]),
        ]);
    }
}*/
