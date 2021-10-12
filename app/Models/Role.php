<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
// Config
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\DataTable;
use DB;


class Role extends \Spatie\Permission\Models\Role implements Auditable { 

    use SoftDeletes, \OwenIt\Auditing\Auditable, DataTable;

    protected $dates = ['deleted_at'];

    public function selectData($actions){
        return [
            'roles.name as roles_name',
            'roles.id as key_id',
            DB::raw("'".$actions."' as actions")
        ];
    }

    public function dataTableQuery(){
        return self::where($this->table.".id", "<>", 0);
    }

}