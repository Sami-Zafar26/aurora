<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignTemplate extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'campaign_template_name',
        'campaign_template_subject',
        'campaign_template_body',
        'user_id',
    ];
}
