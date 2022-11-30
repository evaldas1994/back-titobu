<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Category::TABLE_NAME, function (Blueprint $table) {
            $table->string('icon')->default('fa-solid fa-piggy-bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Category::TABLE_NAME, function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
