<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    public function login(Request $req)
    {
        //set the rules for validation
        $rules = [
            'password' => 'required',
            'email' => 'required|email:rfc,dns'
        ];

        $validation = Validator::make($req->all(), $rules);

        if ($validation->fails()) {
            return response()->json([
                "result" => false,
                "error" => $validation->errors()
            ]);
        }
        //get the user with the email
        $user = User::where('email', $req->email)->first();
        //check if the email is there or not
        if (!$user) {
            return ["result" => "user not found", "success" => false];
        }
        //check if the password is same as the stored password or not
        if (!Hash::check($req->password, $user->password)) {
            return ["result" => "wrong credentials", "success" => false];
        }
        // Using token name from config
        $tokenName = config('app_constants.token_name');
        $success['token'] = $user->createToken($tokenName)->plainTextToken;

        $user['name'] = $user->name;

        //send the response
        return [
            'success' => true,
            'result' => $success,
            "msg" => "user login successfully"
        ];
    }

    public function Signup(Request $req)
    {
        //set the rules for validation
        $rules = [
            'name' => 'required|string|min:2',
            'password' => 'required|min:8',
            'email' => 'required|email:rfc,dns|unique:users,email'
        ];

        $validation = Validator::make($req->all(), $rules);

        if ($validation->fails()) {
            return response()->json([
                "result" => false,
                "error" => $validation->errors()
            ]);
        }
        //get all the data from the input fields
        $input = $req->all();
        //search user with the same email
        $user = User::where('email', $req->email)->first();
        //check if the user with same mail id exists or not
        if ($user) {
            return ["result" => "user already exists", "success" => false];
        }
        //bcrypt the password
        $input["password"] = bcrypt($input["password"]);
        //send data to the table
        $user = User::create($input);
        // Using token name from config
        $tokenName = config('app_constants.token_name');
        $success['token'] = $user->createToken($tokenName)->plainTextToken;

        $user['name'] = $user->name;
        //send the response
        return [
            'success' => true,
            'result' => $success,
            "msg" => "user registered successfully"
        ];
    }
}
