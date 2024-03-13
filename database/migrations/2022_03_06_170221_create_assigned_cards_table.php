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
        Schema::create('assigned_cards', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->foreignId('dealer_id')->constrained();
            $table->date('date_from');
            $table->date('date_to');
            $table->text('comments')->nullable();
            $table->enum('status', ['open','closed'])->default('open');
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
        Schema::dropIfExists('assigned_cards');
    }
};
