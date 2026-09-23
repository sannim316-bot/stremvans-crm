<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('funds', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->unique();

            $table->enum('fund_type', [
                'Mutual Fund',
                'Fixed Income',
                'Equity Fund',
                'Dollar Fund',
                'Other'
            ]);

            $table->string('currency', 3)->default('NGN');

            $table->decimal('current_nav', 18, 6)->default(0);

            $table->date('nav_date')->nullable();

            $table->enum('status', [
                'Active',
                'Inactive'
            ])->default('Active');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funds');
    }
};