<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechReport extends Model
{
    use HasFactory;

    protected $table = 'report_technician';
    protected $fillable = [
        'report_id',
        'device',
        'brand',
        'kerusakan',
        'imageUrl',
        'imageDesc',
    ];
}
