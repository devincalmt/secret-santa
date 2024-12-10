<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecretSanta extends Model
{
    // Define the relationship for the giver (User who gives the gift)
    public function giver()
    {
        return $this->belongsTo(User::class, 'giver_id');
    }

    // Define the relationship for the receiver (User who receives the gift)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
