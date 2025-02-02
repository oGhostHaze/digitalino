<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'address'];

    // A school has many students
    public function students() {
        return $this->hasMany(Student::class);
    }
}