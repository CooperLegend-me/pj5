<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('house_type');
            $table->string('roof_type');
            $table->string('foundation_type');
            $table->string('finishing_material');
            $table->string('windows_type');
            $table->string('heating_type');
            $table->string('sewage_type');
            $table->string('construction_time');
            $table->json('additional_services')->nullable();
            $table->decimal('total_cost', 12, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}; 