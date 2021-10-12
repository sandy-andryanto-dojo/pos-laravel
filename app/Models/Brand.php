<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Config
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\DataTable;
use DB;
// Relation
use App\Models\Product;

class Brand extends Model implements Auditable{

    use SoftDeletes, \OwenIt\Auditing\Auditable, DataTable;
        
    protected $dates = ['deleted_at'];
	protected $table = 'brands';
    protected $fillable = [
        'name',
        'description',
    ];

    public function Product() {
        return $this->hasMany(Product::class);
    }

    public function selectData($actions){
        return [
            'brands.name as brands_name',
            'brands.description as brands_description',
            'brands.id as key_id',
            DB::raw("'".$actions."' as actions")
        ];
    }

    public function dataTableQuery(){
        return self::where($this->table.".id", "<>", 0);
    }
   
}