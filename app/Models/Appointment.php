<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
       'id', 'date', 'time', 'offer_id', 'user_id',
    ];

    public function offer() : BelongsTo{
        return $this->belongsTo(Offer::class);
    }

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
}
