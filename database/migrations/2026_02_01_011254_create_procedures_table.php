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
         Schema::create('procedures', function (Blueprint $table) {
        $table->id();

        $table->foreignId('citizen_id')->constrained()->cascadeOnDelete();
        $table->foreignId('procedure_type_id')->constrained()->cascadeOnDelete();

        $table->string('folio')->unique();
        $table->enum('status', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
        $table->text('notes')->nullable();
        $table->date('submitted_at');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
