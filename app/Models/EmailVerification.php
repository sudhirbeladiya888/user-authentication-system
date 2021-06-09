<?php
/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailVerification extends Model
{
    protected $table = "email_verifications";
    public $timestamps = true;

    protected $fillable = [
        'email',
        'code',
        'token',
        'expires_at',
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at','created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];
}