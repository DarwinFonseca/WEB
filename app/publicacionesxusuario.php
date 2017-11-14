<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class publicacionesxusuario extends Model
{
    //Diligencia automática
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
    ];
}
