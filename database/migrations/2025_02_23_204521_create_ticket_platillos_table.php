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
        Schema::create('ticket_platillos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id'); // Relación con el ticket
            $table->unsignedBigInteger('platillo_id'); // Relación con el platillo
            $table->integer('cantidad'); // Cantidad de platillos en la compra
            $table->decimal('precio', 8, 2); // Precio por platillo en la compra
            $table->decimal('subtotal', 8, 2); // Precio por platillo en la compra
            $table->timestamps();

            // Relación con el ticket
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');

            // Relación con el platillo
            $table->foreign('platillo_id')->references('id')->on('platillos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_platillos');
    }
};
