<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CsvList;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        'first_name',
        'last_name',
        'email',
        'phone',
        'city',
        'state',
        'country',
        'designation',
        'json_data',
        'token',
        'csv_list_id',
    ];

    function leads_belongsto_csv_lists() {
        return $this->belongsTo(CsvList::class,'csv_list_id');
    }
}
