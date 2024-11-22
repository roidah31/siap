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
        Schema::create('usersubmenu', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->constrained('menu')->onDelete('cascade');
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('icon');
            $table->string('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usersubmenu');
    }
};
