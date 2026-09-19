<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('portfolios', function (Blueprint $table) {

            $table->date('maturity_date')->nullable();

            $table->string('custodian_bank')->nullable();

            $table->string('custodian_account_name')->nullable();

            $table->decimal('current_nav_price', 15, 4)->nullable();

        });
    }

    public function down()
    {
        Schema::table('portfolios', function (Blueprint $table) {

            $table->dropColumn([
                'maturity_date',
                'custodian_bank',
                'custodian_account_name',
                'current_nav_price'
            ]);

        });
    }
};