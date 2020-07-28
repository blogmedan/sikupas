<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    //
  protected $table = "matapelajaran";

  protected $fillable = ['id_sekolah','a_sekolah','kode','n_pelajaran'];
}
