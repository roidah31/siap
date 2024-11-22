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
        Schema::create('useraccessmenu', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->constrained()->onDelete('cascade');
            $table->integer('menu_id')->constrainde()->onDelete('cascade');
            $table->boolean('access')->default(true);
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('useraccessmenu');
    }
};
