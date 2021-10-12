<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Config
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\DataTable;
use DB;
// Relations
use App\Models\Transaction;


class Customer extends Model implements Auditable{

    use SoftDeletes, \OwenIt\Auditing\Auditable, DataTable;
        
    protected $dates = ['deleted_at'];
	protected $table = 'customers';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'website',
        'address'
    ];

    public function Transaction() {
        return $this->hasMany(Transaction::class);
    }

    public function selectData($actions){
        return [
            'customers.name as customers_name',
            'customers.email as customers_email',
            'customers.phone as customers_phone',
            'customers.id as key_id',
            DB::raw("'".$actions."' as actions")
        ];
    }

    public function dataTableQuery(){
        return self::where($this->table.".id", "<>", 0);
    }

   
}