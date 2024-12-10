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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('parking_number');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('vehicle_company');
            $table->string('registration_number');
            $table->string('owner_name');
            $table->integer('owner_contact');
            $table->string('owner_email')->unique();
            $table->timestamp('intime')->nullable();
            $table->timestamp('outtime')->nullable();
            $table->integer('charges');
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
