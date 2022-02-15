<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('fullname');
            $table->string('photo')->nullable();
            $table->string('tel');
            $table->enum('type', ['plumber', 'carpenter', 'air-conditionair', 'electrician']);
            $table->boolean('active')->default(true);
            $table->boolean('archived')->default(false);
            $table->foreignId('user_id')->nullable()->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}