<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserConfirm;
use App\Models\Role;

class UserController extends AdminController{

    public function __construct(){
        $this->layout = "pages.users";
        $this->route = "users";
        $this->model = new User;
    }

    public function create(){
        $items = array();
        $items["route"] = $this->route;
        $items["roles"] = Role::all();
        return view($this->layout.".create", $items);
    }

    public function edit($id){

        if($id == \Auth::User()->id){
            return abort(404); 
        }

        $model = User::findOrfail($id);
        if(is_null($model)){
            return abort(404);  
        }

        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        $items["roles"] = Role::all();
        return view($this->layout.".edit", $items);
    }

    public function show($id){

        if($id == \Auth::User()->id){
            return abort(404); 
        }

        $model = $this->model->where("id", $id)->first();
        if(is_null($model)){
            return abort(404);  
        }

        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        return view($this->layout.".show", $items);
    }

    public function store(Request $request){
        $rules = $this->createValidation();

        if($request->get('phone')) $rules["phone"] = 'required|regex:/^[0-9]+$/|unique:users';
       

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $token = base64_encode(strtolower($request->get("email").'.'.str_random(10)));
            $roleName = Role::whereIn("id", $request->get("roles"))->get()->pluck("name")->toArray();

            $user = new User;
            $user->username = $request->get("username");
            $user->email = $request->get("email");
            $user->password = bcrypt($request->get('password'));
            $user->access = json_encode($roleName);
            $user->confirm = 1;
            $user->remember_token = $token;

            if($request->get("phone")){  $user->phone = $request->get("phone"); }

            $user->save();

            $this->syncPermissions($request, $user);
            $id = $user->id;
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_CREATED);
        }
    }

    public function update($id, Request $request){
        $rules = $this->updateValidation($id);

        if($request->get('phone')) $rules["phone"] = 'required|regex:/^[0-9]+$/|unique:users,phone,'.$id;
        if($request->get('password')) $rules["password"] = 'required|string|min:6|confirmed';

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{

            $roleName = Role::whereIn("id", $request->get("roles"))->get()->pluck("name")->toArray();
           
            $user = User::findOrfail($id);
            $user->username = $request->get("username");
            $user->email = $request->get("email");
            $user->access = json_encode($roleName);

            if($request->get("password")) $user->password = bcrypt($request->get('password'));
            if($request->get("phone")) $user->phone = $request->get("phone");

            $user->save();
            $this->syncPermissions($request, $user);

            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPDATED);
        }
    }

    protected function createValidation(){
        return [
            'username' => 'required|alpha_dash|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required|min:1',
        ];
    }

    protected function updateValidation($id){
        return [
            'username' => 'required|alpha_dash|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|min:1',
        ];
    }

    private function syncPermissions(Request $request, $user){
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if(!$user->hasAllRoles($roles) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        $confirm = UserConfirm::where("user_id", $user->id)->first();
        if(is_null($confirm)){
            $token = base64_encode(strtolower($user->email.'.'.str_random(10)));
            UserConfirm::Create([
                'user_id'=>$user->id,
                'token'=>$token
            ]);
        }

        return $user;
    }
    
}