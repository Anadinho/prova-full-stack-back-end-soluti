<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    protected $fillable=[
        'id',
        'nome',
        'cpf',
        'email',
        'dataNascimento',
        'password',
        'endereco_id'
    ];

    public function endereco()
    {
        return $this->belongsTo('App\Models\Endereco');
    }
    
   
    public function setPasswordAttribute(string $password): void
    {     
        $this->attributes['password'] = Hash::make($password);
    }


    //   protected $visible=[
    //     'created_at',
    //     'updated_at'
    // ];

     
     protected $hidden=[
        'created_at',
        'updated_at',
        'password'
    ];


    /**
     * exemplo de serialização no eloquent
     */
    // protected $casts=[
    //     'dataNascimento' =>'date:d/m/Y'
    // ];

        /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
            
 
}
