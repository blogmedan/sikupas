<?php

namespace App\Imports;

use App\Pelajaran;
use Crypt;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class PelajaranImport implements ToModel, WithHeadingRow // USE CLASS YANG DIIMPORT
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $c_pelajaran=DB::table('matapelajaran')->where('n_pelajaran',$row['nama_pelajaran'])->where('id_sekolah',Session::get('id_sekolah'))->count();
        if($c_pelajaran<1){
        return new Pelajaran([
            'id_sekolah' => Session::get('id_sekolah'),
            'a_sekolah' => Session::get('name'),
            'kode' => $row['kode'],
            'n_pelajaran' => $row['nama_pelajaran'],
        ]);
        }else{
            Session::flash('gagal','Data Mata Pelajaran dengan Nama '.$row['nama_pelajaran'].' Sudah Terdaftar!');
        }
    }
}
