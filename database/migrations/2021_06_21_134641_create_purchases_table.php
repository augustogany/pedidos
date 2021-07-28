<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('date');
			$table->string('nit')->nullable();
            $table->string('invoice_number',50)->nullable();
            $table->string('authorization_number')->nullable();
            $table->decimal('total', 8,2)->nullable();
            $table->decimal('discount', 8,2)->nullable();
            $table->string('status',20);
            $table->text('observation');
            $table->foreignId('typedocument_id')
                  ->nullable()
                  ->constrained('types');
            $table->foreignId('contact_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('company_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
