<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plant_id', 'user_id', 'quantitiy', 'total', 'status', 'payment_url',
    ];

    public function plant()
    {
        return $this->hasOne(Plant::class, 'id', 'plant_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCreatedAtAtrribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
    public function getUpdateAtAtrribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
