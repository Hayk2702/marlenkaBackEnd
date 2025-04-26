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
        Schema::table('user_profiles', function (Blueprint $table) {
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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn("company_name");
            $table->dropColumn("apartment");
            $table->dropColumn("state");
            $table->dropColumn("zip_code");
            $table->dropColumn("notes");
        });
    }
};
