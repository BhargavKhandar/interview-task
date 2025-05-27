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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("manufactuer")->nullable();
            $table->string("product_type")->nullable();
            $table->string("price")->nullable();
            $table->string("km")->nullable();
            $table->string("month")->nullable();
            $table->string("vehicle_type")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
