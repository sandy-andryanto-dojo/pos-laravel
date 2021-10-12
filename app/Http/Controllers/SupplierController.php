<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends AdminController{

    public function __construct(){
        $this->layout = "pages.suppliers";
        $this->route = "suppliers";
        $this->model = new Supplier;
    }

    protected function createValidation(){
        return [
            'name' => 'required|unique:suppliers',
            'phone' => 'required|unique:suppliers',
            'email' => 'required|unique:suppliers',
        ];
    }

    protected function updateValidation($id){
        return [
            'name' => 'required|unique:suppliers,name,' . $id,
            'phone' => 'required|unique:suppliers,phone,' . $id,
            'email' => 'required|unique:suppliers,email,' . $id,
        ];
    }
    
}