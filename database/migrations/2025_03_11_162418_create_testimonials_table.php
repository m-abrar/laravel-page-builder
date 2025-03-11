<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name'); // Customer name
            $table->string('designation')->nullable(); // Job title (optional)
            $table->text('message'); // Testimonial message
            $table->string('image')->nullable(); // Customer image (optional)
            $table->integer('rating')->default(5); // Star rating (1-5)
            $table->boolean('status')->default(1); // 1=Active, 0=Inactive
            $table->timestamps(); // Created_at & Updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
