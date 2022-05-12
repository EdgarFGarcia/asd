<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Hash, Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;

class UserController extends Controller
{
    //
    private $userinstance;
    private $roleinstance;

    function __construct(){
        $this->userinstance = new UserRepository();
        $this->roleinstance = new RoleRepository();
    }
    
    public function adduser(Request $requests){
        // return $requests->all();
        $validation = Validator::make($requests->all(), [
            'name'              => 'required|string',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string',
            'roles_id'          => 'required|numeric',
            'access_level_id'   => 'nullable|numeric'
        ]);

        if($validation->fails()){
            return response()->json([
                'response'      => false,
                'message'       => $validation->messages()->first()
            ], 422);
        }

        User::create([
            'name'              => $requests->name,
            'email'             => $requests->email,
            'password'          => Hash::make($requests->password),
            'roles_id'          => $requests->roles_id,
            'access_level_id'   => $requests->access_level_id
        ]);

        return response()->json([
            'response'  => true
        ], 200);
    }

    public function getusersinfo(){
        return User::with('roles', 'access_level')->get();
    }

    public function getuserinfo($id = null){
        return [
            $this->userinstance->getUserInfoMeow($id),
            $this->roleinstance->get_role($id)
        ];
    }

    public function login(Request $requests){
        $authcheck = Auth::attempt([
            'email'     => $requests->email,
            'password'  => $requests->password
        ]);
        if($authcheck){
            $token = $requests->user()->createToken($requests->email);
            return response()->json([
                'response'  => true,
                'data'      => $token->plainTextToken
            ], 200);
        }
    }

    public function resetpassword(Request $requests){
        $data = User::where('email', $requests->email)->first();
        $encryptid = Crypt::encryptString($data->id);
        $url = "https://client.profitabletradesmen.com/resetpassword/";

        return response()->json([
            'link'      => $url . $encryptid,
            'decrypt'   => Crypt::decryptString($encryptid)
        ], 200);
    }
}
