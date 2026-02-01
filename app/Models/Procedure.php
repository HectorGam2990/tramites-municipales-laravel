<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_id',
        'procedure_type_id',
        'folio',
        'status',
        'notes',
        'submitted_at',
    ];

    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }

    public function procedureType()
    {
        return $this->belongsTo(ProcedureType::class);
    }
}
