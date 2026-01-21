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
        Schema::create('reconducted_reservations', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('original_reservation_uuid');
            $table->uuid('new_reservation_uuid')->nullable();
            $table->uuid('old_appart_uuid');
            $table->uuid('new_appart_uuid');
            $table->decimal('old_total_price', 10, 2);
            $table->decimal('new_total_price', 10, 2);
            $table->decimal('already_paid', 10, 2);
            $table->decimal('remaining_to_pay', 10, 2);
            $table->decimal('amount_to_pay_now', 10, 2);
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('original_reservation_uuid')->references('uuid')->on('reservations');
            $table->foreign('new_reservation_uuid')->references('uuid')->on('reservations');
            $table->foreign('old_appart_uuid')->references('uuid')->on('appartements');
            $table->foreign('new_appart_uuid')->references('uuid')->on('appartements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reconducted_reservations');
    }
};

