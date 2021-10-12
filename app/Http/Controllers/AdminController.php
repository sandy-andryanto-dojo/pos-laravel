<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\Authorizable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class AdminController extends Controller{

    use Authorizable;

    protected $layout, $model, $route;

    const SUCCESS_MESSAGE_CREATED = "Record created successfully";
    const SUCCESS_MESSAGE_UPDATED = "Record updated successfully";
    const SUCCESS_MESSAGE_DELETED = "Record deleted successfully";
    const FAILED_MESSAGE_CREATED = "Record created unsuccessfully";
    const FAILED_MESSAGE_UPDATED = "Record updated unsuccessfully";
    const FAILED_MESSAGE_DELETED = "Record deleted unsuccessfully";

    public function index(){
        $items = array();
        $items["route"] = $this->route;
        return view($this->layout.".index", $items);
    }

    public function create(){
        $items = array();
        $items["route"] = $this->route;
        return view($this->layout.".create", $items);
    }

    public function store(Request $request){
        $rules = $this->createValidation();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $post = $request->all();
            $data = $this->model->create($post);
            $id = $data->id;
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_CREATED);
        }
    }

    public function show($id){
        $model = $this->model->where("id", $id)->first();
        if(is_null($model)){
            return abort(404);  
        }

        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        return view($this->layout.".show", $items);
    }

    public function edit($id){
        $model = $this->model->where("id", $id)->first();
        if(is_null($model)){
            return abort(404);  
        }

        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        return view($this->layout.".edit", $items);
    }

    public function update($id, Request $request){
        $rules = $this->updateValidation($id);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $post = $request->all();
            $data = $this->model->where("id", $id)->first();
            $data->fill($post);
			$data->save();
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPDATED);
        }
    }

    public function destroy($id){
        $model = $this->model->where("id", $id)->first();
        if(is_null($model)){
            return abort(404);  
        }

        $this->model->where("id", $id)->delete();
        return redirect()->route($this->route.".index")->with('success', self::SUCCESS_MESSAGE_DELETED);
    }

    protected function createValidation(){
        return array();
    }

    protected function updateValidation($id){
        return array();
    }
    
}