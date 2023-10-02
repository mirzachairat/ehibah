<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function daftar(Request $request, User $user)
  {
    $this->validate($request,[
         'name' => 'required|min:6',
        'address' => 'required|min:6',
        'email' => 'required|email|unique:user',
        'username' => 'required|unique:user',
        'ktp' => 'required|min:16|unique:user',
        'phone' => 'required|min:11|unique:user',
        'password' => 'required|min:6'
      ]);

         $User = new User;
                $User->ktp = $request->ktp;
                $User->username = $request->username;
                $User->address = $request->address;
                $User->phone = $request->phone;
                $User->name = $request->name;
                $User->email = $request->email;
                $User->password = bcrypt($request->password);
                $User->api_token = str_random(60);
                $User->is_active = 1;
                $User->save();
                $role='7';
                $User->syncRoles([$role]);

                $data['name'] = $User->name;
                $data['username'] = $User->username;
                $data['email'] = $User->email;
                $data['address'] = $User->address;
                $data['api_token'] = $User->api_token;
                $data['status'] = '201';
                $data['pesan'] = 'Pendaftaran Sukses untuk Acccount '.$User->username;
        return response()->json($data, 201);
  }


    public function login(Request $request, User $user)
  {
    if(!Auth::attempt(['username'=> $request->username, 'password' => $request->password])){
      return response()->json(['error'=>'Username atau Password Salah'], 401);
    }
      $user = $user->find(Auth::user()->id);
      $user->api_token =str_random(60);
      $user->save();
      $data['role'] =Auth::user()->roles->first()->id;
      $data['status'] = '201';
      $data['pesan'] = 'Selamat Datang '.$user->username;
      $data['api_token'] = $user->api_token;
      $data['is_skpd'] =$user->is_skpd;
      $data['skpd_id'] =$user->skpd_id;
      return response()->json($data, 201);

  }
  
  public function profile(User $user){
    $user = $user->find(Auth::user()->id);
    return response()->json($user, 200);
   
  }
}
