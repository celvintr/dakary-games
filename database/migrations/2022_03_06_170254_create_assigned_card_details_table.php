<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_card_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_card_id')->constrained();
            $table->foreignId('card_id')->constrained();
            $table->string('code', 15)->unique();
            $table->decimal('price', 15, 2);
            $table->decimal('comission', 15, 2);
            $table->string('file', 191)->nullable();
            $table->text('comments')->nullable();
            $table->boolean('reassigned')->default(false);
            $table->enum('status', ['pending','changed','canceled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigned_card_details');
    }
};
