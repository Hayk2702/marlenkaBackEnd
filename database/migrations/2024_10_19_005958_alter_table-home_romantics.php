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
        Schema::table('home_romantics', function (Blueprint $table) {
            $table->string("image_path_two")->after("description_two")->nullable();
            $table->string("image_path_three")->after("description_three")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_romantics', function (Blueprint $table) {
            //
        });
    }
};
