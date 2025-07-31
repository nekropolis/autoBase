<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instruction_modification', function (Blueprint $table) {
            $table->foreignId('instruction_id')->constrained()->onDelete('cascade');
            $table->foreignId('modification_id')->constrained()->onDelete('cascade');
            $table->primary(['instruction_id', 'modification_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruction_modification');
    }
};
