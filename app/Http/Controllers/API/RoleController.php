<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\RoleRepository;

class RoleController extends Controller
{
    //
    private $roleinstance;

    function __construct(){
        $this->roleinstance = new RoleRepository();
    }

    public function getRole($id = null){
        return $this->roleinstance->get_role($id);
    }
}
