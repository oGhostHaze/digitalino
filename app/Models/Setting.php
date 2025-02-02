<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'adaptive_difficulty', 'sound_effects', 'music_volume'];

    // A setting belongs to a user
    public function user() {
        return $this->belongsTo(User::class);
    }
}