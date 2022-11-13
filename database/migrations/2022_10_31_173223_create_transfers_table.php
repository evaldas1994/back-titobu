<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Account;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount', 10, 2);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('account_id');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on(Category::TABLE_NAME)
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');

            $table->foreign('account_id')
                ->references('id')
                ->on(Account::TABLE_NAME)
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
};
