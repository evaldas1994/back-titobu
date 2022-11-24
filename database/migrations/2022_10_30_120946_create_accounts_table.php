<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Account;
use App\Models\User;

return new class extends Migration
{
    public function up()
    {
        Schema::create(Account::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('balance', 10, 2)->default(0.00);

            $table->foreignId('user_id')
                ->constrained(User::TABLE_NAME)
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Account::TABLE_NAME);
    }
};
