<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('problem_modification', function (Blueprint $table) {
            $table->foreignId('problem_id')->constrained()->onDelete('cascade');
            $table->foreignId('modification_id')->constrained()->onDelete('cascade');
            $table->primary(['problem_id', 'modification_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('problem_modification');
    }
};
