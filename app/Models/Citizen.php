<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'curp',
        'phone',
        'email',
    ];

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }
}
