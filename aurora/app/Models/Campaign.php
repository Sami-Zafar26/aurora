<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'campaign_name',
        'sent',
        'opened',
        'clicked',
        'user_id',
        'is_active',
        'status',
        'date',
        'time',
        'utc_time',
        'timezone_id',
        'csv_list_id',
        'campaign_template_id',
        'integration_credential_id',
    ];

    function campaignLeads() {
        return $this->hasMany(Lead::class,'csv_list_id','csv_list_id');
    }

    function campaignTimezone() {
        return $this->hasOne(Timezone::class,'id','timezone_id');
    }

    // public function campaignTimezone()
    // {
    //     return $this->hasOneThrough(
    //         Timezone::class,
    //         Schedule::class,
    //         'id',            // Local key on the Campaigns table
    //         'id',            // Foreign key on the Schedules table
    //         'schedule_id',   // Foreign key on the Campaigns table
    //         'timezone_id'    // Foreign key on the Schedules table
    //     );
    // }
}
