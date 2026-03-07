<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bảng stock_company
        Schema::create('stock_company', function (Blueprint $table) {
            $table->id();
            $table->string('stock_company')->nullable();
            $table->string('stock_company_code')->nullable();
            $table->decimal('stock_company_fee_ratio', 5, 3)->nullable();
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });

        // Bảng stock_history
        Schema::create('stock_history', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type')->nullable();
            $table->string('stock_company_code')->nullable();
            $table->string('stock_code')->nullable();
            $table->integer('stock_volume')->nullable();
            $table->decimal('stock_price', 12, 2)->nullable();
            $table->date('stock_date')->nullable();
            $table->decimal('total_money', 15, 2)->nullable();
            $table->decimal('total_fee', 15, 2)->nullable();
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });

        // Bảng nav_savings
        Schema::create('nav_savings', function (Blueprint $table) {
            $table->id();
            $table->string('bank_code')->nullable();
            $table->decimal('money_saving', 15, 2)->nullable();
            $table->decimal('money_deposit', 15, 2)->nullable();
            $table->decimal('deposit_rate', 5, 2)->nullable();
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->string('note')->nullable();
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });

        // Bảng stock (giá chứng khoán)
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->string('stock_code')->nullable();
            $table->decimal('price_open', 12, 2)->nullable();
            $table->decimal('price_close', 12, 2)->nullable();
            $table->decimal('price_high', 12, 2)->nullable();
            $table->decimal('price_low', 12, 2)->nullable();
            $table->date('stock_date')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });

        // Bảng nav_history (stock_nav)
        Schema::create('stock_nav', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type')->nullable();
            $table->string('stock_company_code')->nullable();
            $table->date('nav_date')->nullable();
            $table->decimal('total_money', 15, 2)->nullable();
            $table->decimal('total_fee', 15, 2)->nullable();
            $table->string('note')->nullable();
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });

        // Bảng note_to_do
        Schema::create('note_to_do', function (Blueprint $table) {
            $table->id();
            $table->string('work')->nullable();
            $table->text('detail')->nullable();
            $table->string('priority')->nullable();
            $table->string('state')->nullable();
            $table->date('deadline')->nullable();
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_company');
        Schema::dropIfExists('stock_history');
        Schema::dropIfExists('nav_savings');
        Schema::dropIfExists('stock');
        Schema::dropIfExists('stock_nav');
        Schema::dropIfExists('note_to_do');
    }
};
