<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->unique();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->integer("stock")->default(0);
            $table->double('price_purchase', 19, 2)->default(0);
            $table->double('price_sales', 19, 2)->default(0);
            $table->decimal('price_profit')->default(0);
            $table->date('date_expired')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->index('brand_id');
            $table->index('type_id');
            $table->index('supplier_id');
        });

        Schema::create('products_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
            $table->index(['product_id', 'category_id']);
            $table->primary(["product_id", "category_id"]);
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_categories');
    }
}
