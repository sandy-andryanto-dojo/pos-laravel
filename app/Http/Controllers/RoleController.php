<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends AdminController{

    public function __construct(){
        $this->layout = "pages.roles";
        $this->route = "roles";
        $this->model = new Role;
    }

    public function create(){
        $items = array();
        $items["route"] = $this->route;
        $items["permissions"] = [
            Permission::where("name", "LIKE", "%view%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%add%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%edit%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%delete%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
        ];
        return view($this->layout.".create", $items);
    }

    public function show($id){
        $model = Role::findOrfail($id);
        if(is_null($model)){
            return abort(404);  
        }

        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        $items["permissions"] = [
            Permission::where("name", "LIKE", "%view%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%add%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%edit%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%delete%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
        ];
        return view($this->layout.".show", $items);
    }

    public function edit($id){
        $model = Role::findOrfail($id);
        if(is_null($model)){
            return abort(404);  
        }

        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        $items["permissions"] = [
            Permission::where("name", "LIKE", "%view%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%add%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%edit%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%delete%")->where("name","NOT LIKE","%profiles%")->orderBy("name", "ASC")->get(),
        ];
        return view($this->layout.".edit", $items);
    }

    public function store(Request $request){
        $rules = $this->createValidation();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $role = Role::create($request->only('name'));
            $permissions = $request->get('permissions', []);
            $actions =  ["view","add","edit","delete"];
            $addons = ["profiles"];
            foreach($actions as $action){
                foreach($addons as $add){
                    $permissions[] = $action."_".$add;
                }
            }
            $role->syncPermissions($permissions);
            $id = $role->id;
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_CREATED);
        }
    }

    public function update($id, Request $request){
        $rules = $this->updateValidation($id);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $role = Role::findOrfail($id);
            $role->name = $request->get("name");
            $permissions = $request->get('permissions', []);
            $role->save();
            $actions =  ["view","add","edit","delete"];
            $addons = ["profiles"];
            foreach($actions as $action){
                foreach($addons as $add){
                    $permissions[] = $action."_".$add;
                }
            }
            $role->syncPermissions($permissions);
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPDATED);
        }
    }

    protected function createValidation(){
        return [
            'name' => 'required|unique:roles',
            'permissions' => 'required|min:1',
        ];
    }

    protected function updateValidation($id){
        return [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required|min:1',
        ];
    }
    
}