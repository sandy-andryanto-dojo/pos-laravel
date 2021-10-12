<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\Authorizable;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ReportController extends Controller{

    use Authorizable;

    public function index(){
        $start = new Carbon('first day of this month');
        $last =  new Carbon('last day of this month');
        return view('pages.reports.index', ["firstDate" => $start->toDateString(), "lastDate"=> $last->toDateString()]);
    }

    public function create(){
        return abort(404);  
    }

    public function store(Request $request){
        return abort(404);  
    }

    public function show($id){
        $arr = explode("_", $id);
        $model = new Transaction;

        if(count($arr) == 4){
            $report = (int) $arr[0];
            $type = (int) $arr[1];
            $firstDate = $arr[2];
            $lastDate = $arr[3];
            
            if($report == 0){
                
                if($type == 1){
                    $data = $model->purhcaseByPeriode($firstDate, $lastDate);
                    return view("pages.reports.purchase1", ["data" => $data]);
                }

                if($type == 2){
                    $data = $model->purchaseBySupplier($firstDate, $lastDate);
                    return view("pages.reports.purchase2", ["data" => $data]);
                }

                if($type == 3){
                    $data = $model->purchaseByproduct($firstDate, $lastDate);
                    return view("pages.reports.purchase3", ["data" => $data]);
                }

            }

            if($report == 1){
                
                if($type == 1){
                    $data = $model->saleByPeriode($firstDate, $lastDate);
                    return view("pages.reports.sale1", ["data" => $data]);
                }

                if($type == 2){
                    $data = $model->saleByCustomer($firstDate, $lastDate);
                    return view("pages.reports.sale2", ["data" => $data]);
                }

                if($type == 3){
                    $data = $model->saleByproduct($firstDate, $lastDate);
                    return view("pages.reports.sale3", ["data" => $data]);
                }

            }

            return abort(404); 
        }
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