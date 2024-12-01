<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipRegistration extends Model
{
    // Daftar kolom yang dapat diisi (mass assignment)
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

    /**
     * Casting tipe data untuk beberapa kolom
     * Cast IPK ke decimal dengan 2 angka di belakang koma
     * Cast semester ke integer
     */
    protected $casts = [
        'ipk' => 'decimal:2',
        'semester' => 'integer',
    ];
}
