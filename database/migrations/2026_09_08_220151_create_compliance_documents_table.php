<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('compliance_documents', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('document_type', [
                'Passport',
                'NIN',
                'BVN',
                'Signature',
                'Proof of Address',
                'AOD Form',
            ]);

            $table->string('file_path');

            $table->enum('status', [
                'Pending',
                'Approved',
                'Rejected',
            ])->default('Pending');

            $table->text('remarks')->nullable();

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('compliance_documents');
    }
};