<?php 

namespace App\Http\Controllers\Api;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Brand;
use App\Models\Transaction;
use DB;


class ManageController extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $this->middleware('auth:api');
    }

    public function dataTable($route, $model, Request $request){
        $buttons = array();
        $user = \Auth::user();
        if($user->can("view_".$route)){
            $buttons[] = '<a href="javascript:void(0);" data-route="'.route($route.".show", ['id'=> 'row_id']).'" class="btn btn-success btn-sm btn-show"><i class="fa fa-search"></i></a>';
        }
        if($user->can("edit_".$route)){
            $buttons[] = '<a href="javascript:void(0);" data-route="'.route($route.".edit", ['id'=> 'row_id']).'" class="btn btn-info btn-sm btn-edit"><i class="fa fa-edit"></i></a>';
        }
        if($user->can("delete_".$route)){
            $buttons[] = '<a href="javascript:void(0);" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a>';
        }
        $actions = implode("&nbsp;", $buttons);
        $modelClass = str_replace("/", '\\', base64_decode($model));
        $m = new $modelClass;

        if($route == 'purchases'){
            $m->setType(0);
        }

        if($route == 'sales'){
            $m->setType(1);
        }

        $result = $m->dataTable($actions, $request->all());
        return response()->json($result);
    }

    public function remove($model, $id){
        $modelClass = str_replace("/", '\\', base64_decode($model));
        $m = new $modelClass;
        $result = $m->findOrfail($id)->delete();
        return response()->json($result);

    }

    public function getProduct(Request $request){
        $search = $request->get("q");
        $type = (int)$request->get("type");
        $key = $type == 0 ? "price_purchase" : "price_sales";
        $result = Product::select([
            "id as id",
            "sku as sku",
            "name as text",
            "stock as stock",
            $key." as price",
        ])
        ->where("stock", $type == 0 ? "=" : ">", 0)
        ->where(function($q) use ($search) {
            $q->where('sku', 'LIKE', '%'.$search.'%');
            $q->orWhere('name', 'LIKE', '%'.$search.'%');
        })
        ->take(10)
        ->orderBy("name","ASC")
        ->get();
        return response()->json($result);
    }

    public function getDashboard(Request $request){
        $transaction = new Transaction;
        $items = array();
        $items["product"] = Product::count();
        $items["supplier"] = Supplier::count();
        $items["customer"] = Customer::count();
        $items["brand"] = Brand::count();
        $items["purchase"] = $transaction->getPurchaseDashboard();
        $items["sale"] = $transaction->getSaleDashboard();
        $items["chartPurchase"] = $transaction->getReportByYear(0);
        $items["chartSale"] = $transaction->getReportByYear(1);
        return response()->json($items);
    }


}