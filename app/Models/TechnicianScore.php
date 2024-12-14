<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicianScore extends Model
{
    use HasFactory;

    protected $fillable = ['tech_id', 'score', 'rank'];

    public function technician()
    {
        return $this->belongsTo(User::class, 'tech_id');
    }
}
