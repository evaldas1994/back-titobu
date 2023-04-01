<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PeriodCategory;
use App\Models\Category;
use App\Models\Period;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PeriodCategory::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->float('limit')->default(0.00);

            $table->foreignId('period_id')
                ->constrained(Period::TABLE_NAME)
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained(Category::TABLE_NAME)
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained(User::TABLE_NAME)
                ->restrictOnUpdate()
                ->restrictOnDelete();

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
        Schema::dropIfExists(PeriodCategory::TABLE_NAME);
    }
};
