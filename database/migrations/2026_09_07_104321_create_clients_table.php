<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {

            $table->id();

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name')->nullable();

            $table->string('email')->unique();
            $table->string('phone');
            $table->date('date_of_birth')->nullable();

            $table->enum('gender', [
                'Male',
                'Female',
            ])->nullable();

            // Investment Details
            $table->string('client_code')->unique();
            $table->string('investment_type')->nullable();

            $table->decimal('investment_amount', 15, 2)
                  ->default(0);

            // Compliance
            $table->enum('kyc_status', [
                'Pending',
                'Approved',
                'Rejected',
            ])->default('Pending');

            // Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};