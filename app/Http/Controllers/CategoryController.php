<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends AdminController{

    public function __construct(){
        $this->layout = "pages.categories";
        $this->route = "categories";
        $this->model = new Category;
    }

    protected function createValidation(){
        return [
            'name' => 'required|unique:categories',
        ];
    }

    protected function updateValidation($id){
        return [
            'name' => 'required|unique:categories,name,' . $id,
        ];
    }
    
}