<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('portfolio_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('transaction_type', [
                'Buy',
                'Redeem',
                'Dividend',
                'Bonus Units',
            ]);

            $table->decimal('amount', 15, 2);

            $table->decimal('units', 12, 4)->default(0);

            $table->decimal('nav_price', 12, 2);

            $table->date('transaction_date');

            $table->string('reference')->unique();

            $table->text('remarks')->nullable();

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};