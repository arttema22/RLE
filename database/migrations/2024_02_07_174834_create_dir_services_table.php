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
        Schema::create('dir_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->unique();
            $table->float('price', 8, 2);
            $table->text('comment')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir_services');
    }
};
