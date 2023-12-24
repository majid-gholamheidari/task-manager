<?php

use App\Models\Board;
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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('board_code', 8)->unique();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->enum('status', [Board::Active, Board::Inactive])->default(Board::Active);
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('progress')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
