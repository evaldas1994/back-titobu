<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Transfer;
use App\Models\Account;
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
        Schema::create(Transfer::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount', 10, 2);

            $table->foreignId('user_id')
                ->constrained(User::TABLE_NAME)
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained(Category::TABLE_NAME)
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('account_id')
                ->constrained(Account::TABLE_NAME)
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
        Schema::dropIfExists(Transfer::TABLE_NAME);
    }
};
