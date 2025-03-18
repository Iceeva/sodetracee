<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bales', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('reference')->unique(); // Référence alphanumérique unique
            $table->string('quality'); // Qualité de la balle
            $table->float('weight'); // Poids en kg
            $table->text('private_data')->nullable(); // Données privées (optionnelle en fonction des restriction de la SODECO )
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bales'); // Supprime la table si elle existe lors d’un rollback
    }
};