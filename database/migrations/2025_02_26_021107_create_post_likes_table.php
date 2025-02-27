<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('cascade');
            $table->timestamps();

            // Đảm bảo 1 user/doctor chỉ like 1 lần
            $table->unique(['post_id', 'user_id', 'doctor_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_likes');
    }
};
