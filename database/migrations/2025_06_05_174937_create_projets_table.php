<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('projets', function (Blueprint $table) {
        $table->id('idPr');
        $table->string('nom');
        $table->text('description')->nullable();
        $table->date('date_debut');
        $table->date('date_fin');
        $table->enum('etat', ['Planifié', 'En cours', 'Terminé', 'Annulé'])->default('Planifié');
        $table->unsignedBigInteger('responsable_id'); // Sans contrainte ici
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};