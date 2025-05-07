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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('access_right')->default(0);
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamp('date_start')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'phone', 'address', 'status', 'date_start']);
        });
    }
};
