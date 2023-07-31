<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Room::class)
                ->nullable()
                ->constrained();
            $table->string('nickname')->unique();
            $table->tinyInteger('age')->default(18);
            $table->string('gender')->default(\App\Models\Guest::GENDER_FEMALE);
            $table->string('ip')->index();
            $table->string('key')->unique();
            $table->timestamps();

            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
};
