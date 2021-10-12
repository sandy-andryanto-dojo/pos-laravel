<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Type;
use App\Models\File;
use App\Models\Supplier;

class ProductController extends AdminController{

    public function __construct(){
        $this->layout = "pages.products";
        $this->route = "products";
        $this->model = new Product;
    }

    
    public function create(){
        $items = array();
        $items["route"] = $this->route;
        $items["categories"] = Category::orderBy("name")->get();
        $items["brands"] = Brand::orderBy("name")->get();
        $items["types"] = Type::orderBy("name")->get();
        $items["suppliers"] = Supplier::orderBy("name")->get();
        return view($this->layout.".create", $items);
    }

    public function store(Request $request){
        $rules = $this->createValidation();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{

            $product = Product::create([
                "sku"=> $request->get("sku"),
                "name"=> $request->get("name"),
                "brand_id"=> $request->get("brand_id"),
                "supplier_id"=> $request->get("supplier_id"),
                "type_id"=> $request->get("type_id"),
                "price_purchase"=> $request->get("price_purchase"),
                "price_sales"=> $request->get("price_sales"),
                "price_profit"=> $request->get("price_profit"),
                "stock"=> $request->get("stock"),
                "date_expired"=> $request->get("date_expired") ? $request->get("date_expired") : null,
                "description"=> $request->get("description"),
                "notes"=> $request->get("notes"),
            ]);

            if($request->get("categories")){
                $product->Category()->sync($request->get("categories"));
            }

            $id = $product->id;
            $this->uploadImage($request, $id);

            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_CREATED);
        }
    }

    public function update($id, Request $request){
        $rules = $this->updateValidation($id);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            
            Product::where("id", $id)->update([
                "sku"=> $request->get("sku"),
                "name"=> $request->get("name"),
                "brand_id"=> $request->get("brand_id"),
                "supplier_id"=> $request->get("supplier_id"),
                "type_id"=> $request->get("type_id"),
                "price_purchase"=> $request->get("price_purchase"),
                "price_sales"=> $request->get("price_sales"),
                "price_profit"=> $request->get("price_profit"),
                "stock"=> $request->get("stock"),
                "date_expired"=> $request->get("date_expired") ? $request->get("date_expired") : null,
                "description"=> $request->get("description"),
                "notes"=> $request->get("notes"),
            ]);

            $product = Product::findOrfail($id);

            if($request->get("categories")){
                $product->Category()->sync($request->get("categories"));
            }

            $id = $product->id;
            $this->uploadImage($request, $id);

            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPDATED);
        }
    }

    public function show($id){
        $model = $this->model->where("id", $id)->first();
        if(is_null($model)){
            return abort(404);  
        }

        $image = asset("no-image.png");
        $file = File::where("model_id", $id)->where("model_name", "App\Models\Product")->first();
        if(!is_null($file)){
            $fileExsist = $file->path;
            if(file_exists(public_path($file->path))){
               $image = $file->path;
            }
        }

        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        $items["image"] = $image;
        return view($this->layout.".show", $items);
    }

    public function edit($id){
        $model = $this->model->where("id", $id)->first();
        if(is_null($model)){
            return abort(404);  
        }

        $image = asset("no-image.png");
        $file = File::where("model_id", $id)->where("model_name", "App\Models\Product")->first();
        if(!is_null($file)){
            $fileExsist = $file->path;
            if(file_exists(public_path($file->path))){
               $image = $file->path;
            }
        }

        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        $items["image"] = $image;
        $items["categories"] = Category::orderBy("name")->get();
        $items["brands"] = Brand::orderBy("name")->get();
        $items["types"] = Type::orderBy("name")->get();
        $items["suppliers"] = Supplier::orderBy("name")->get(); 
        return view($this->layout.".edit", $items);
    }

    protected function createValidation(){
        return [
            'sku' => 'required|unique:products',
            'name' => 'required|unique:products',
            'categories' => 'required|min:1',
            'brand_id' => 'required',
            'type_id' => 'required',
            'supplier_id' => 'required',
        ];
    }

    protected function updateValidation($id){
        return [
            'sku' => 'required|unique:products,sku,' . $id,
            'name' => 'required|unique:products,name,' . $id,
            'categories' => 'required|min:1',
            'brand_id' => 'required',
            'type_id' => 'required',
            'supplier_id' => 'required',
        ];
    }

    private function uploadImage(Request $request, $id){
        if($request->file('file')){

            $image = null;
            $file = $request->file('file');
            $imageName = md5(rand(0,1000)."".time()).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $imageName);
            $image = '/uploads/'.$imageName;

            $file = File::where("model_id", $id)->where("model_name", "App\Models\Product")->first();
            if(!is_null($file)){
                $fileExsist = $file->path;
                if(file_exists(public_path($file->path))){
                    unlink(public_path($file->path));
                }
                $file->path = $image;
                $file->save();
                return $file;
            }else{
                return File::create([
                    'model_id'=> $id,
                    'model_name'=> 'App\Models\Product',
                    'name'=> 'Product Image',
                    'type'=> mime_content_type(public_path($image)),
                    'size'=> filesize(public_path($image)),
                    'path'=> $image
                ]);
            }

        }
        return null;
    }
    
}