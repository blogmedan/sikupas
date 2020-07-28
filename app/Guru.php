<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    //
  protected $table = "guru";

  protected $fillable = ['id_sekolah','nip','a_sekolah','nuptk','n_guru','username','password','email'];
}
