<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';
    protected $fillable = [
        'customer_id',
        'tech_id',
        'rating',
        'comments',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'tech_id', 'techID');
    }
}
