<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $fillable=[
        'id',
        'titular',
        'dataValidade',
        'dn',
        'inssuerDn',
        'usuario_id'    
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

      protected $casts=[
          'dataValidade' =>'datetime:d/m/Y H:i:s'
    ];
}
