<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Customer;
use App\Models\Product;
use DB;

class SaleController extends AdminController{

    public function __construct(){
        $this->layout = "pages.sales";
        $this->route = "sales";
        $this->model = new Transaction;
    }

    public function create(){
        $invoice_number = Transaction::createInvoiceNumber(1);
        $model = Transaction::create([
            'casheir_id'=> \Auth::User()->id,
            'type' => 1,
            'status' => 0,
            'invoice_number'=> $invoice_number,
            'invoice_date'=> date("Y-m-d")
        ]);
        return redirect()->route($this->route.".edit", ["id"=>$model->id]);
    }

    public function edit($id){

        $model = $this->model->where("id", $id)->where("status", 0)->first();
        if(is_null($model)){
            return abort(404);  
        }


        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        $items["customers"] = Customer::orderBy("name")->get(); 
        return view($this->layout.".edit", $items);
    }

    public function show($id){

        $slug = explode("-", $id);
        if(count($slug) > 0){
            if(isset($slug[1])){
                return $this->printInvoice($slug[1]);
            }
        }

        $model = $this->model->where("id", $id)->first();
        if(is_null($model)){
            return abort(404);  
        }


        $items = array();
        $items["model"] = $model;
        $items["route"] = $this->route;
        $items["details"] = TransactionDetail::where("transaction_id", $id)->get();
        return view($this->layout.".show", $items);
    }

    public function update($id, Request $request){

        $product_id = $request->get("product_id");
        $price = $request->get("price");
        $qty = $request->get("qty");
        $total = $request->get("total");
        $totalItems = 0;
     
        if(count($product_id) > 0){
            DB::table("transactions_details")->where("transaction_id", $id)->delete();
            for($i = 0; $i < count($product_id); $i++){
                TransactionDetail::create([
                    "transaction_id"=> $id,
                    "product_id"=> isset($product_id[$i]) ? $product_id[$i] : null,
                    "price"=> isset($price[$i]) ? $price[$i] : 0,
                    "qty"=> isset($qty[$i]) ? $qty[$i] : 0,
                    "total"=> isset($total[$i]) ? $total[$i] : 0,
                ]);
                $totalItems += $qty[$i];
                $product = Product::findOrfail($product_id[$i]);
                $product->stock = $product->stock - $qty[$i];
                $product->save();
            }
        }

        Transaction::where("id", $id)->update([
            "status" => 1,
            "customer_id"=> $request->get("customer_id"),
            "total_items"=> $totalItems,
            "subtotal"=> $request->get("subtotal"),
            "discount"=> $request->get("discount"),
            "tax"=> $request->get("tax"),
            "grandtotal"=> $request->get("grandtotal"),
            "cash"=> $request->get("cash"),
            "change"=> $request->get("change"),
        ]);

        return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPDATED);
    }

    public function printInvoice($id){
        $model = $this->model->where("id", $id)->first();
        if(is_null($model)){
            return abort(404);  
        }
        $details = TransactionDetail::where("transaction_id", $id)->get();
        return view($this->layout.".print", ["model"=> $model, "details" => $details]);
    }
    
}