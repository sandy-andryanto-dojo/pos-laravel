<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use App\Notifications\ResetPassword;
// Config
use App\Traits\DataTable;
use DB;
// Relations
use App\Models\Role;
use App\Models\UserConfirm;
use App\Models\Transaction;

class User extends Authenticatable implements JWTSubject, Auditable
{
    use Notifiable, SoftDeletes, HasRoles, \OwenIt\Auditing\Auditable, DataTable;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'phone', 'password', 'confirm', 'session_id', 'access',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function transformAudit(array $data): array {
        if (Arr::has($data, 'new_values.role_id')) {
            $data['old_values']['role_name'] = Role::find($this->getOriginal('role_id'))->name;
            $data['new_values']['role_name'] = Role::find($this->getAttribute('role_id'))->name;
        }
        return $data;
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token));
    }

    public function Confirm() {
        return $this->hasOne(UserConfirm::class);
    }

    public function Transaction() {
        return $this->hasMany(Transaction::class);
    }

    public function selectData($actions){
        return [
            'users.username as users_username',
            'users.email as users_email',
            'users.access as users_access',
            'users.id as key_id',
            DB::raw("'".$actions."' as actions")
        ];
    }

    public function dataTableQuery(){
        $user_id = \Auth::User()->id;
        return self::where("users.id", "!=", $user_id);
    }
}
