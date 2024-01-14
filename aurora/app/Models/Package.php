<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "packages";
    protected $primaryKey = "id";
    protected $fillable = [
        'package_name',
        'compaign_allowed',
        'lead_allowed',
        'package_duration',
        'package_price',
    ];

    function package_subscription_by_users() {
        return $this->belongsToMany(Package::class,Subscription::class);
    }
}
