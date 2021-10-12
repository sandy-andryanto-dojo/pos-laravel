<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Traits\Authorizable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DashboardController extends AppController{

    use Authorizable;

    public function index(){
        return view("pages.dashboards.index");
    }

    public function create(){
        return abort(404);   
    }

    public function store(Request $request){
        return abort(404);   
    }   

    public function show($id){
        return abort(404);   
    }

    public function edit($id){
        return abort(404);   
    }

    public function update($id, Request $request){
        return abort(404);   
    }

    public function destroy($id){
        return abort(404);   
    }
    
}