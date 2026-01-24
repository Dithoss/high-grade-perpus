<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fines', function (Blueprint $table) {
            if (!Schema::hasColumn('fines', 'payment_method')) {
                $table->enum('payment_method', ['cash', 'tripay'])->nullable()->after('status');
            }

            if (!Schema::hasColumn('fines', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('payment_method');
            }
        });
    }

    public function down()
    {
        Schema::table('fines', function (Blueprint $table) {
            if (Schema::hasColumn('fines', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('fines', 'payment_reference')) {
                $table->dropColumn('payment_reference');
            }
        });
    }
};
