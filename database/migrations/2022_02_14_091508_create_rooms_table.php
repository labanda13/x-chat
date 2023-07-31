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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(\App\Models\Room::STATUS_ACTIVE)->index();
            $table->string('visibility')->default(\App\Models\Room::VISIBILITY_PUBLIC)->index();
            $table->string('name')->unique();
            $table->integer('guest_count')->default(0);
            $table->integer('guest_limit')->default(1000);
            $table->integer('message_limit')->default(200);
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
        Schema::dropIfExists('rooms');
    }
};
