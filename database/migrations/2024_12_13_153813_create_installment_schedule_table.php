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
        Schema::create('installment_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->integer('installment_to');
            $table->integer('installment_per_month');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->timestamps();

            $table->foreign('contract_id')->references('id')->on('contract')->onUpdate('Cascade')->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_schedule');
    }
};
