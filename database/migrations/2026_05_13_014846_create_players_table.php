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
    Schema::create('players', function (Blueprint $table) {
        $table->id();

        // Time do jogador
        $table->foreignId('team_id')
            ->constrained()
            ->onDelete('cascade');

        // Nome
        $table->string('name');

        // Posição
        $table->string('position');

        // Número da camisa
        $table->integer('shirt_number')->nullable();

        // Nacionalidade
        $table->string('nationality');

        // Data de nascimento
        $table->date('birth_date')->nullable();

        // Overall futuro
        $table->integer('overall')->nullable();

        // Foto futura
        $table->string('photo')->nullable();

        // Jogador ativo?
        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
