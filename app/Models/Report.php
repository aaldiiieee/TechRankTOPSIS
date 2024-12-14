<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Feedback;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customerID',
        'techID',
        'taskDate',
        'reportDate',
    ];

    public $incrementing = false;
    protected function setUUID()
    {
        $this->id = preg_replace('/\./', '', uniqid('bpm', true));
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'tech_id', 'techID');
    }
}
