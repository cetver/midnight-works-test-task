<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('public_id', 7)->nullable(false)->unique();
            $table->unsignedInteger(NestedSet::LFT)->default(0);
            $table->unsignedInteger(NestedSet::RGT)->default(0);
            $table->string('name')->nullable(false)->unique();
            $table->string('parent_id', 36)->nullable(true);

            $table->index([NestedSet::LFT, NestedSet::RGT]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
