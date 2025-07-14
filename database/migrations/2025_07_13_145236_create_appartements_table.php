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
        Schema::create('appartements', function (Blueprint $table) {
            $table->id();
            $table->string('appartement_code')->unique();
            $table->string('property_code')->unique();
            $table->string('title')->nullable();
             $table->string('price')->nullable();
            $table->string('available')->nullable();
            $table->string('appartType')->nullable();
            $table->string('bedroomsNumber')->nullable();
            $table->string('bathroomsNumber')->nullable();
            $table->string('CommoditiesHomesafety')->nullable();
            $table->string('CommoditiesBedroom')->nullable();
            $table->string('CommoditiesKitchen')->nullable();
            $table->string('video_url')->nullable();
            $table->string('main_image')->nullable();
            $table->longText('description')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('etat')->nullable()->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
