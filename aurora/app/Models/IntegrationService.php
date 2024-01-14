<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationService extends Model
{
    use HasFactory;

    function integration_credential_of_users() {
        return $this->hasMany(IntegrationCredential::class);
    }
}
