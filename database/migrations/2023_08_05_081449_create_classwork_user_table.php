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
        Schema::create('class_work_user', function (Blueprint $table) {
           $table->foreignId('class_work_id')->nullable()->constrained('class_works','id')->cascadeOnDelete();
           $table->foreignId('user_id')->nullable()->constrained('users','id')->cascadeOnDelete();
           $table->float('grade')->nullable();
           $table->timestamp('submitted_at')->nullable();
           $table->enum('status',['assigned','draft','submitted','returned'])->default('assigned');
           $table->timestamps(); // This will add created_at and updated_at columns
           $table->primary(['class_work_id', 'user_id']);

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
