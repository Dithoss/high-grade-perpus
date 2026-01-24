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
        Schema::create('fines', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('transaction_id')->index();
            $table->foreign('transaction_id')
                ->references('id')->on('transactions')
                ->onDelete('cascade');

            $table->enum('type', ['late', 'broken', 'lost', 'manual']);

            $table->integer('late_days')->nullable();
            $table->integer('amount');

            $table->text('note')->nullable();

            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamp('paid_at')->nullable();

             $table->enum('payment_method', ['cash', 'tripay'])->nullable();
             $table->string('payment_reference')->nullable(); 

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
