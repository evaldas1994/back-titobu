<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
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
        Schema::create(Category::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('balance', 10, 2)->default(0.00);
            $table->string('type')->default(Category::TYPE_OUT);

            $table->foreignId('account_id')
                ->constrained(Account::TABLE_NAME)
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
        Schema::dropIfExists(Category::TABLE_NAME);
    }
};
