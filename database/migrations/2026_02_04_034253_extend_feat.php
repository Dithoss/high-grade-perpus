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
       Schema::table('transactions', function (Blueprint $table) {

            if (!Schema::hasColumn('transactions', 'is_extended')) {
                $table->boolean('is_extended')
                    ->default(false)
                    ->after('status');
            }

            if (!Schema::hasColumn('transactions', 'extended_due_at')) {
                $table->date('extended_due_at')
                    ->nullable()
                    ->after('due_at');
            }

            if (!Schema::hasColumn('transactions', 'extension_requested_at')) {
                $table->timestamp('extension_requested_at')
                    ->nullable()
                    ->after('extended_due_at');
            }

            if (!Schema::hasColumn('transactions', 'extension_approved_at')) {
                $table->timestamp('extension_approved_at')
                    ->nullable()
                    ->after('extension_requested_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'is_extended',
                'extended_due_at',
                'extension_requested_at',
                'extension_approved_at',
            ]);
        });
    }
};
