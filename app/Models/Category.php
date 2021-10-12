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


class Category extends Model implements Auditable{

    use SoftDeletes, \OwenIt\Auditing\Auditable, DataTable;
        
    protected $dates = ['deleted_at'];
	protected $table = 'categories';
    protected $fillable = [
        'name',
        'description',
    ];

    public function Product() {
        return $this->belongsToMany(Product::class, "products_categories");
    }

    public function selectData($actions){
        return [
            'categories.name as categories_name',
            'categories.description as categories_description',
            'categories.id as key_id',
            DB::raw("'".$actions."' as actions")
        ];
    }

    public function dataTableQuery(){
        return self::where($this->table.".id", "<>", 0);
    }
}