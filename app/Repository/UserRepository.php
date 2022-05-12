<?php

namespace App\Repository;

use App\Models\User;

class UserRepository{
    public function getUserInfoMeow($id){
        return User::where('id', $id)->first();
    }
}