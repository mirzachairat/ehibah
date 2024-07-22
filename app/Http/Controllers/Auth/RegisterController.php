<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'ktp' => 'required|numeric|digits:16|unique:user',
            'username' => 'required|string|unique:user',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'ktp' => $data['ktp'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'is_active' => '1',
            'status' => '1',
        ]);
        $role = $data['role'];
        $user->syncRoles([$role]);
        return $user;
    }
}
