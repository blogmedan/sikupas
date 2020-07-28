<?php

namespace App\Imports;

use App\Guru;
use Session;
use Crypt;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class GuruImport implements ToModel, WithHeadingRow // USE CLASS YANG DIIMPORT
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $c_user=DB::table('guru')->where('username',$row['username'])->count();
        if($c_user<1){
            return new Guru([
                'id_sekolah' => Session::get('id_sekolah'),
                'nip' => $row['nip'],
                'nuptk' => $row['nuptk'],
                'n_guru' => $row['nama'],
                'a_sekolah' => Session::get('name'),
                'username' => $row['username'],
                'password' => Crypt::encrypt($row['password']),
                'email' => $row['email'],
            ]);
        }else{
            Session::flash('gagal','Data Username Guru '.$row['username'].' Sudah Terdaftar!');
        }
    }
}
