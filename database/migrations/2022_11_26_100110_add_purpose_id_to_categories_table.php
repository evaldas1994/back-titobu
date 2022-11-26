<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Purpose;

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
            $table->foreignId('purpose_id')->nullable()
                ->constrained(Purpose::TABLE_NAME)
                ->restrictOnUpdate()
                ->restrictOnDelete();
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
            $table->dropColumn('purpose_id');
        });
    }
};
