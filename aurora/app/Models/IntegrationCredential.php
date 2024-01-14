<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegrationCredential extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'json_field_value',
        'integration_service_id',
        'user_id',
    ];

    function integrated_services() {
        return $this->belongsTo(IntegrationService::class);
    }
}
