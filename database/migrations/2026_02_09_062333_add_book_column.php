<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'sypnosis')) {
                $table->longText('sypnosis')->nullable()->after('barcode');
            }
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'sypnosis')) {
                $table->dropColumn('sypnosis');
            }
        });
    }
};
