<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Config
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\DataTable;
use DB;
// Relations
use App\Models\Brand;
use App\Models\Type;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\TransactionDetail;

class Product extends Model implements Auditable{

    use SoftDeletes, \OwenIt\Auditing\Auditable, DataTable;
        
    protected $dates = ['deleted_at'];
	protected $table = 'products';
    protected $fillable = [
        'sku',
        'name',
        'brand_id',
        'type_id',
        'supplier_id',
        'stock',
        'price_purchase',
        'price_sales',
        'price_profit',
        'date_expired',
        'description',
        'notes'
    ];

    public function Brand(){
        return $this->belongsTo(Brand::class, "brand_id");
    }

    public function Type(){
        return $this->belongsTo(Type::class, "type_id");
    }

    public function Supplier(){
        return $this->belongsTo(Supplier::class, "supplier_id");
    }

    public function Category() {
        return $this->belongsToMany(Category::class, "products_categories");
    }

    public function TransactionDetail() {
        return $this->hasMany(TransactionDetail::class);
    }

    public static function createNumber(){
        $num1 = rand(100,999);
        $num2 = rand(100,999);
        $number = "PROD".$num1."".$num2;
        $prod = self::where("sku", $number)->first();
        if(!is_null($prod)){
            $number = self::createNumber();
        }
        return $number;
    }

    public function selectData($actions){
        return [
            'products.sku as products_sku',
            'products.name as products_name',
            'products.stock as products_stock',
            'products.id as key_id',
            DB::raw("'".$actions."' as actions")
        ];
    }

    public function dataTableQuery(){
        return self::where($this->table.".id", "<>", 0);
    }  
   
}