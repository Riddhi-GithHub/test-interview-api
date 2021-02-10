<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends BaseController
{

    public function register(Request $request)
    {
         $validator = Validator::make($request->all(), [
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email|unique:users',
        'phone' => 'required|max:10|unique:users',
        'password' => 'required|min:6|max:6',
    ]);

    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
    }

    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $user = User::create($input);
    // dd($user);
    // $success['firstname'] =  $user->firstname;

    return $this->sendResponse($user->toArray(), 'User register successfully.');
    // return $this->sendResponse($success, 'User register successfully.');
}
}
