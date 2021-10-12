<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends AdminController{

    public function __construct(){
        $this->layout = "pages.types";
        $this->route = "types";
        $this->model = new Type;
    }

    protected function createValidation(){
        return [
            'name' => 'required|unique:types',
        ];
    }

    protected function updateValidation($id){
        return [
            'name' => 'required|unique:types,name,' . $id,
        ];
    }
    
}