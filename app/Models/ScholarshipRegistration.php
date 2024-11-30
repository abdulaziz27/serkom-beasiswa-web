<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipRegistration extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'semester',
        'ipk',
        'scholarship_type',
        'document_path',
        'status'
    ];

    protected $casts = [
        'ipk' => 'decimal:2',
        'semester' => 'integer',
    ];
}