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
    Schema::create('teams', function (Blueprint $table) {
        $table->id();

        // Nome do time
        $table->string('name');

        // Nome curto (CAP, FLA, PAL...)
        $table->string('short_name', 10);

        // Slug para URL/API
        $table->string('slug')->unique();

        // País
        $table->string('country');

        // Cidade
        $table->string('city');

        // Ano de fundação
        $table->year('founded_year')->nullable();

        // URL do escudo futuramente
        $table->string('logo')->nullable();

        // Time ativo?
        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
