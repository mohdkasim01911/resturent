<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->enum('variant_type', ['none', 'multiple'])->default('none')->after('price');
            $table->json('variants')->nullable()->after('variant_type');
        });
    }

    public function down(): void
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->dropColumn(['variant_type', 'variants']);
        });
    }
};