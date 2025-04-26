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
        Schema::table('orders', function (Blueprint $table) {
            $table->string("name")->nullable();
            $table->string("surname")->nullable();
            $table->string("email")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("country")->nullable();
            $table->string("city")->nullable();
            $table->string("address")->nullable();
            $table->string("company_name")->nullable();
            $table->string("apartment")->nullable();
            $table->string("state")->nullable();
            $table->string("zip_code")->nullable();
            $table->text("notes")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("name");
            $table->dropColumn("surname");
            $table->dropColumn("email");
            $table->dropColumn("phone_number");
            $table->dropColumn("country");
            $table->dropColumn("city");
            $table->dropColumn("address");
            $table->dropColumn("company_name");
            $table->dropColumn("apartment");
            $table->dropColumn("state");
            $table->dropColumn("zip_code");
            $table->dropColumn("notes");
        });
    }
};
