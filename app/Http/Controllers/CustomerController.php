<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends AdminController{

    public function __construct(){
        $this->layout = "pages.customers";
        $this->route = "customers";
        $this->model = new Customer;
    }

    protected function createValidation(){
        return [
            'name' => 'required|unique:customers',
            'phone' => 'required|unique:customers',
            'email' => 'required|unique:customers',
        ];
    }

    protected function updateValidation($id){
        return [
            'name' => 'required|unique:customers,name,' . $id,
            'phone' => 'required|unique:customers,phone,' . $id,
            'email' => 'required|unique:customers,email,' . $id,
        ];
    }
    
}