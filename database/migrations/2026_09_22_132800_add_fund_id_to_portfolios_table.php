<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('portfolios', function (Blueprint $table) {

        $table->foreignId('fund_id')
            ->nullable()
            ->after('client_id')
            ->constrained('funds')
            ->nullOnDelete();

    });
}

public function down()
{
    Schema::table('portfolios', function (Blueprint $table) {

        $table->dropForeign(['fund_id']);
        $table->dropColumn('fund_id');

    });
}
};
