<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    //
  protected $table = "siswa";

  protected $fillable = ['nisn','nama','agama','j_kelamin','id_sekolah','a_sekolah','t_lahir','tgl_lahir','username','password','email'];
}
