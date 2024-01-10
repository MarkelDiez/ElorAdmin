<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('password');
            $table->string('email')->unique(); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address');
            $table->integer('phone');
            $table->string('dni');
            $table->integer('curso')->nullable();
            $table->boolean('fct')->default(0);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('cycle_id')->nullable();
            $table->foreign('cycle_id')->references('id')->on('cycles')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
