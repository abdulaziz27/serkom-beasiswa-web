<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scholarship_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('semester');
            $table->decimal('ipk', 3, 2);
            $table->enum('scholarship_type', ['akademik', 'non_akademik']);
            $table->string('document_path')->nullable();
            $table->enum('status', ['belum di verifikasi', 'terverifikasi'])->default('belum di verifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_registrations');
    }
};
