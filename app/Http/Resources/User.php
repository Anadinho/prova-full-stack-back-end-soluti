<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
            'id' => $this->id,
            'name' => $this->nome,
            'cpf' => $this->cpf,
            'email'=> $this->email,
            'dataNascimento' => $this->dataNascimento,
            'password' => $this->password,
            'endereco' => new Endereco($this->endereco)            
        ];
    }
}
