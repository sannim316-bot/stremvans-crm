<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {

            // Personal Information
            $table->string('middle_name')->nullable();
            $table->string('nationality')->nullable();
            $table->text('residential_address')->nullable();
            $table->string('country')->default('Nigeria');
            $table->string('occupation')->nullable();
            $table->string('employer')->nullable();

            // Investor Classification
            $table->string('client_category')->nullable();
            $table->string('risk_profile')->nullable();
            $table->string('investment_objective')->nullable();

            // Bank Details
            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bvn')->nullable();
            $table->boolean('bank_verified')->default(false);

            // Next of Kin
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->string('next_of_kin_email')->nullable();
            $table->text('next_of_kin_address')->nullable();

            // Internal CRM
            $table->foreignId('relationship_manager_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('kyc_approved_at')->nullable();
            $table->foreignId('kyc_approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {

            $table->dropForeign(['relationship_manager_id']);
            $table->dropForeign(['kyc_approved_by']);

            $table->dropColumn([
                'middle_name',
                'nationality',
                'residential_address',
                'country',
                'occupation',
                'employer',
                'client_category',
                'risk_profile',
                'investment_objective',
                'bank_name',
                'bank_code',
                'account_name',
                'account_number',
                'bvn',
                'bank_verified',
                'next_of_kin_name',
                'next_of_kin_relationship',
                'next_of_kin_phone',
                'next_of_kin_email',
                'next_of_kin_address',
                'relationship_manager_id',
                'kyc_approved_at',
                'kyc_approved_by'
            ]);
        });
    }
};