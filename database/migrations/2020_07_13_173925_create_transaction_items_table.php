<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedInteger('transaction_id')->nullable()
                  ->foreign('transaction_id')
                  ->references('id')->on('transactions')
                  ->onDelete('cascade');
            $table->unsignedInteger('product_id')->nullable()
                  ->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
            $table->unsignedInteger('user_id')->nullable()
                  ->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->boolean('status',false);
            $table->softDeletes();
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
        Schema::dropIfExists('transaction_items',function (Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
}