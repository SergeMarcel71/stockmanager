<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('depots', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            // Le dépôt "actif" de l'utilisateur : celui depuis lequel il travaille.
            // Nullable : un admin peut ne pas être rattaché à un dépôt précis.
            $table->foreignId('depot_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        Schema::table('mouvements_stock', function (Blueprint $table) {
            // Rempli automatiquement à partir du dépôt de l'utilisateur qui fait le mouvement
            $table->foreignId('depot_id')->nullable()->after('produit_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mouvements_stock', function (Blueprint $table) {
            $table->dropConstrainedForeignId('depot_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('depot_id');
        });

        Schema::dropIfExists('depots');
    }
};
