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
        Schema::create('home_romantics', function (Blueprint $table) {
            $table->id();
            $table->string("image_path")->nullable();
            $table->string("small_image_path")->nullable();
            $table->string("title_one")->nullable();
            $table->text("description_one")->nullable();
            $table->string("title_two")->nullable();
            $table->text("description_two")->nullable();
            $table->string("title_three")->nullable();
            $table->text("description_three")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_romantics');
    }
};
