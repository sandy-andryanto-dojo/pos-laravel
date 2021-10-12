<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends AdminController{

    public function __construct(){
        $this->layout = "pages.users";
        $this->route = "profiles";
        $this->model = new User;
    }

    public function index(){
        $items = array();
        $items["route"] = $this->route;
        $items["model"] = \Auth::User();
        return view($this->layout.".profile", $items);
    }

    public function create(){
        return abort(404);  
    }

    public function edit($id){
        return abort(404);  
    }

    public function show($id){
        return abort(404);  
    }

    public function update($id, Request $request){
        return abort(404); 
    }

    public function destroy($id){
        return abort(404); 
    }

    public function store(Request $request){

        $id = \Auth::User()->id;
        $rules = $this->updateValidation($id);

        if($request->get('phone')) $rules["phone"] = 'required|regex:/^[0-9]+$/|unique:users,phone,'.$id;
        if($request->get('password')) $rules["password"] = 'required|string|min:6|confirmed';

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{

            $user = \Auth::User();
            $user->username = $request->get("username");
            $user->email = $request->get("email");
           
            if($request->get("password")) $user->password = bcrypt($request->get('password'));
            if($request->get("phone")) $user->phone = $request->get("phone");

            $user->save();

            return redirect()->route($this->route.".index")->with('success', self::SUCCESS_MESSAGE_UPDATED);
        }
    }

    protected function createValidation(){
        return array();
    }

    protected function updateValidation($id){
        return [
            'username' => 'required|alpha_dash|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ];
    }
    
}