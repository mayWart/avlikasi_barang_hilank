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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
            
            // Kolom Baru: Tipe (Hilang/Nemu) dan Kategori
            $table->enum('type', ['lost', 'found'])->default('lost');
            $table->string('category'); 

            $table->string('item_name'); 
            $table->text('description'); 
            $table->string('image_path'); 
            $table->string('wa_number'); 
            $table->enum('status', ['active', 'resolved'])->default('active'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};