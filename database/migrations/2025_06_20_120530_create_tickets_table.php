<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Ticket\TicketStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('subject');
            $table->text('body');
            $table->enum('status',
                [TicketStatus::NEW->value, TicketStatus::IN_PROGRESS->value, TicketStatus::DONE->value])
                ->default(TicketStatus::NEW->value);
            $table->string('category')->nullable();
            $table->float('confidence')->default(0);
            $table->text('explanation')->nullable();
            $table->text('note')->nullable();
            $table->boolean('isOverride')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
