<?php

namespace App\Repository;

use App\Models\Role;

class RoleRepository{
    public function get_role($id){
        return Role::where('id', $id)->first();
    }
}