<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    //
  protected $table = "sekolah";
 
  protected $fillable = ['npsn','status','n_sekolah','n_k_sekolah','username','password'];
}
