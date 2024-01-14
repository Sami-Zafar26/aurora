<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Database\Eloquent\SoftDeletes;

class CsvList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        'file_name',
        'list_name',
        'list_description',
        'status',
        'token',
        'list_location',
        'processing_started_at',
        'processing_completed_at',
        'user_id',
    ];

    function csv_lists_belongsto_users() {
       return $this->belongsTo(User::class);
    }

    function csv_lists_leads() {
        return $this->hasMany(Lead::class);
    }
}
