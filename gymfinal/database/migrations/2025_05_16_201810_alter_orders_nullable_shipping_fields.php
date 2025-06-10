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
            $table->string('country')->nullable()->change();
            $table->string('province')->nullable()->change();
            $table->string('municipality')->nullable()->change();
            $table->string('postal_code')->nullable()->change();
            $table->string('street')->nullable()->change();
            $table->string('street_number')->nullable()->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
