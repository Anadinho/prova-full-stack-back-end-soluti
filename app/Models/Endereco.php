<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable=[
        'id',
        'logradouro',
        'cep',
        'rua',
        'numero',
        'cidade',
        'estado',   
    ];

    public function usuario()
    {
        return $this->hasMany('App\Models\User');
    }

    
}