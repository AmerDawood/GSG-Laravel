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
        Schema::create('classwork_user', function (Blueprint $table) {
           $table->foreignId('classwork_id')->nullable()->constrained('class_works','id')->cascadeOnDelete();
           $table->foreignId('user_id')->nullable()->constrained('users','id')->cascadeOnDelete();
           $table->float('grade')->nullable();
           $table->timestamp('submitted_at')->nullable();
           $table->enum('status',['assignd','draft','submitted','returned'])->default('assignd');
           $table->timestamp('created_at')->nullable();
           $table->primary('classwork_id','user_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classwork_user');
    }
};
