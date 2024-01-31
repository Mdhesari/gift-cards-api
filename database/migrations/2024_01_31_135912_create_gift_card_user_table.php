<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gift_card_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('gift_card_id')->constrained();
            $table->decimal('quantity');
            $table->primary(['user_id', 'gift_card_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_card_user');
    }
};
