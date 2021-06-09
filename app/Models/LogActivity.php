<?php
/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = "log_activites";
	public $timestamps = true;

    protected $fillable = [
    	"name",
    	"mothod",
    	"version",
    	"request",
    	"response",
    	"channel",
    	"unix_time",
    	"agent",
    	"remote_ip"
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
