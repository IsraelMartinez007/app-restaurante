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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('establecimiento_id'); // Establecimiento donde se realizó la compra
            $table->unsignedBigInteger('mesa_id')->nullable(); // Mesa a la que se asigna el ticket (si aplica)
            $table->decimal('total', 8, 2); // Total de la compra
            $table->timestamp('fecha')->useCurrent(); // Fecha en que se creó el ticket
            $table->timestamps();

            // Relación con el establecimiento
            $table->foreign('establecimiento_id')->references('id')->on('establecimientos')->onDelete('cascade');

            // Relación con la mesa (opcional, si una mesa está asociada a la compra)
            $table->foreign('mesa_id')->references('id')->on('mesas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
