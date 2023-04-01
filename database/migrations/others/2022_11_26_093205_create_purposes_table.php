<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Purpose;
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
        Schema::create(Purpose::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name');

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
        Schema::dropIfExists(Purpose::TABLE_NAME);
    }
};
