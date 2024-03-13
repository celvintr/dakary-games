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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique();
            $table->string('document', 25)->unique();
            $table->string('name', 191);
            $table->string('phone', 25);
            $table->string('company', 191);
            $table->longText('address');
            $table->longText('maps')->nullable();
            $table->string('document_image', 191)->nullable();
            $table->string('business_image', 191)->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
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
        Schema::dropIfExists('dealers');
    }
};
