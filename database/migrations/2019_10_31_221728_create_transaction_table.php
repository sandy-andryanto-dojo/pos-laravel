<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("type")->default(0);
            $table->integer("status")->default(0);
            $table->string('invoice_number')->unique();
            $table->date('invoice_date')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('casheir_id')->nullable();
            $table->integer("total_items")->default(0);
            $table->double('subtotal', 19, 2)->default(0);
            $table->double('discount', 19, 2)->default(0);
            $table->double('tax', 19, 2)->default(0);
            $table->double('grandtotal', 19, 2)->default(0);
            $table->double('cash', 19, 2)->default(0);
            $table->double('change', 19, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->index('supplier_id');
            $table->index('customer_id');
            $table->index('casheir_id');
        });

        Schema::create('transactions_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->double('price', 19, 2)->default(0);
            $table->integer("qty")->default(0);
            $table->double('total', 19, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index('transaction_id');
            $table->index('product_id');
            $table->engine = 'InnoDB';
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('transactions_details');
    }
}
