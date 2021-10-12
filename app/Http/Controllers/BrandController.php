<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends AdminController{

    public function __construct(){
        $this->layout = "pages.brands";
        $this->route = "brands";
        $this->model = new Brand;
    }

    protected function createValidation(){
        return [
            'name' => 'required|unique:brands',
        ];
    }

    protected function updateValidation($id){
        return [
            'name' => 'required|unique:brands,name,' . $id,
        ];
    }
    
}