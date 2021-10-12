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
use App\Models\Transaction;

class Supplier extends Model implements Auditable{

    use SoftDeletes, \OwenIt\Auditing\Auditable, DataTable;
        
    protected $dates = ['deleted_at'];
	protected $table = 'suppliers';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'website',
        'address'
    ];

    public function Product() {
        return $this->hasMany(Product::class);
    }

    public function Transaction() {
        return $this->hasMany(Transaction::class);
    }

    public function selectData($actions){
        return [
            'suppliers.name as suppliers_name',
            'suppliers.email as suppliers_email',
            'suppliers.phone as suppliers_phone',
            'suppliers.id as key_id',
            DB::raw("'".$actions."' as actions")
        ];
    }

    public function dataTableQuery(){
        return self::where($this->table.".id", "<>", 0);
    }
}