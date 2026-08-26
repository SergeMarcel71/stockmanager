<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('utilisateur_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['entree', 'sortie', 'transfert', 'ajustement']);
            $table->unsignedInteger('quantite');
            $table->string('motif')->nullable();
            $table->timestamp('date_mouvement')->useCurrent();
            $table->timestamps();

            // Index composé : on filtrera très souvent "tous les mouvements d'un produit, du plus récent"
            $table->index(['produit_id', 'date_mouvement']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mouvements_stock');
    }
};
