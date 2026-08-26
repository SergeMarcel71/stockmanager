<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->unsignedInteger('delai_livraison_jours')->default(7);
            $table->timestamps();
        });

        Schema::table('produits', function (Blueprint $table) {
            $table->foreignId('categorie_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('fournisseur_id')->nullable()->after('categorie_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropConstrainedForeignId('categorie_id');
            $table->dropConstrainedForeignId('fournisseur_id');
        });

        Schema::dropIfExists('fournisseurs');
        Schema::dropIfExists('categories');
    }
};
