<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class votos extends Model
{
  //Diligencia automática
  //
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id_user','id_publicacion',
  ];
}
