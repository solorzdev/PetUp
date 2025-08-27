<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('veterinaries', function (Blueprint $table) {
            $table->id();

            // Origen
            $table->string('source_id', 40)->nullable()->unique();
            $table->string('source', 20)->default('IIEG');

            // Básicos
            $table->string('name', 200);
            $table->unsignedInteger('activity_code')->nullable();
            $table->string('activity_name', 160)->nullable();

            // Ubicación postal
            $table->string('municipality', 100)->nullable()->index();
            $table->string('locality', 120)->nullable();
            $table->string('neighborhood', 120)->nullable();
            $table->string('postal_code', 10)->nullable();

            // Dirección (partes)
            $table->string('tipo_vial', 40)->nullable();
            $table->string('nom_vial', 160)->nullable();
            $table->string('numero_ext', 20)->nullable();
            $table->string('letra_ext', 10)->nullable();

            // Contacto
            $table->string('phone', 60)->nullable();
            $table->string('email', 160)->nullable();
            $table->string('website', 160)->nullable();

            // Geo + fecha
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->date('date_registered')->nullable();

            // Índices útiles
            $table->index(['lat','lng']);
            $table->index('activity_code');
            $table->index('name');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('veterinaries');
    }
};

