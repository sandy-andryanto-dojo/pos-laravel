<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\Transaction;
use App\Models\Product;

class TransactionDetail extends Model{

    use SoftDeletes;
        
    protected $dates = ['deleted_at'];
	protected $table = 'transactions_details';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'price',
        'qty',
        'total',
    ];

    public function Transaction(){
        return $this->belongsTo(Transaction::class, "transaction_id");
    }

    public function Product(){
        return $this->belongsTo(Product::class, "product_id");
    }
}