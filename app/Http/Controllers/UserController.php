<?php


namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Users as UserCollection;
use App\Models\Endereco;

class UserController extends Controller
{   
  
    // public function index()
    // {
    //     // dd(User::get()->toJson());
    //     if(request()->wantsJson()){
    //         return response()->json(new UserCollection(User::get()), 200);    
    //     }
    //     return response(['message:'=>'Api retorna apenas formato json!! Accept = applicationjson']);
    // }

    // public function store(UserRequest $request)
    // {
    //     return User::create($request->all());              
    // }

    // public function show(User $user)
    // {
    //     if(request()->wantsJson()){
    //         return new UserResource($user);       
    //     }

    //     return response(['message:'=>'Api retorna apenas formato json!! Accept = applicationjson']);
        
    // }

    // public function update(UserRequest $request, User $user)
    // {
    //     $user->update($request->all());
    //     return[];
    // }

    // public function destroy(User $user)
    // {
    //     $user->delete();
    //     return[];
    // }



    public function index()
    {
        // dd(User::get()->toJson());
        if(request()->wantsJson()){
            return response()->json(new UserCollection(User::get()), 200);    
        }
        return response(['message:'=>'Api retorna apenas formato json!! Accept = applicationjson']);
    }

    public function store(Request $request)
    {
        $data=$request->all();

        $endereco_id =Endereco::create($data);
        $data["endereco_id"]=$endereco_id->id;

        $user=User::create($data);

        return $user;
          
    }

    public function show(User $user)
    {
        if(request()->wantsJson()){
            return new UserResource($user);       
        }

        return response(['message:'=>'Api retorna apenas formato json!! Accept = applicationjson']);
        
    }

    public function update(UserRequest $request, User $user)
    {
        // dd($request);
        $user->update($request->all());
        return[];
    }

    public function destroy(User $user)
    {
        $user->delete();
        return[];
    }
}
