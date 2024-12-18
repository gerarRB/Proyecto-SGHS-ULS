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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->string('email',150);
            $table->string('phone',15);
            $table->string('carnet',10);
            $table->string('total_hours',4);
            $table->string('student_hours',4);
            $table->string('description',1000);

            $table->foreignId('department_id')
            ->constrained('departments')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreignId('place_id')
            ->constrained('places')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreignId('year_id')
            ->constrained('years')
            ->onUpdate('cascade')->onDelete('restrict');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
