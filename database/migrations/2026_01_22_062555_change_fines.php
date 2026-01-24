<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('fines', function (Blueprint $table) {
            if (!Schema::hasColumn('fines', 'status')) {
                $table->enum('status', ['unpaid', 'paid', 'pending_confirmation'])->default('unpaid');
            }

            if (!Schema::hasColumn('fines', 'payment_requested_at')) {
                $table->timestamp('payment_requested_at')->nullable();
            }

            if (!Schema::hasColumn('fines', 'rejection_note')) {
                $table->text('rejection_note')->nullable();
            }

            if (!Schema::hasColumn('fines', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable();
            }

            if (!Schema::hasColumn('fines', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('fines', function (Blueprint $table) {
            if (Schema::hasColumn('fines', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('fines', 'payment_requested_at')) {
                $table->dropColumn('payment_requested_at');
            }
            if (Schema::hasColumn('fines', 'rejection_note')) {
                $table->dropColumn('rejection_note');
            }
            if (Schema::hasColumn('fines', 'rejected_at')) {
                $table->dropColumn('rejected_at');
            }
            if (Schema::hasColumn('fines', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
