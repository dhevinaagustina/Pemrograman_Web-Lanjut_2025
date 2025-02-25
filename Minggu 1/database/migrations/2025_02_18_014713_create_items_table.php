<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. (Membuat Tabel Items)
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();                   // Primary key (auto-increment)
            $table->string('name');         // Kolom name (string)
            $table->string('description');  // Kolom description (string)
            $table->timestamps();           // Kolom created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
