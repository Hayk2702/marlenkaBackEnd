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
        Schema::create('user_cards', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("number")->nullable();
            $table->string("holder")->nullable();
            $table->string("cvv")->nullable();
            $table->string("date")->nullable();
            $table->string("pin")->nullable();
            $table->string("address")->nullable();
            $table->string("zip_code")->nullable();
            $table->boolean("default")->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_cards');
    }
};
