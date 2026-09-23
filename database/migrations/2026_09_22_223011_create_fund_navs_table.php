<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fund_navs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fund_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('nav_price', 18, 6);

            $table->date('nav_date');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique([
                'fund_id',
                'nav_date'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('fund_navs');
    }
};