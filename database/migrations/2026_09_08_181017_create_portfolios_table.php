<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('portfolios', function (Blueprint $table) {

        $table->id();

        // Link portfolio to client
        $table->foreignId('client_id')
              ->constrained()
              ->cascadeOnDelete();

        // Investment information
        $table->string('fund_name');

        $table->enum('investment_type', [
            'Mutual Fund',
            'Fixed Income',
            'Equity Fund',
            'Dollar Fund',
        ]);

        $table->decimal('amount_invested', 15, 2);

        $table->decimal('units', 12, 4)->default(0);

        $table->decimal('nav_price', 12, 2)->default(0);

        $table->date('investment_date');

        $table->enum('status', [
            'Active',
            'Closed',
        ])->default('Active');

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolios');
    }
};
