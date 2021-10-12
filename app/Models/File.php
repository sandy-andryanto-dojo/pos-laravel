<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class File extends Model{

    use SoftDeletes;
        
    protected $dates = ['deleted_at'];
	protected $table = 'files';
    protected $fillable = [
        'model_id',
        'model_name',
        'name',
        'type',
        'size',
        'path'
    ];

   
}