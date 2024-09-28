<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'brand',
        'service_type',
        'payment_method',
        'imageUrl',
        'imageDesc',
    ];
}
