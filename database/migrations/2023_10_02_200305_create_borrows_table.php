<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->date('return_at')->nullable();
            $table->unsignedInteger('books_borrowed')->default(0);
            $table->unsignedInteger('books_returned')->default(0);
            $table->unsignedDouble('late_price')->default(config('perpustakaan.late_price'));
            $table->unsignedDouble('book_price')->default(config('perpustakaan.book_price'));
            $table->string('created_by')->nullable()->default('System');
            $table->string('updated_by')->nullable()->default('System');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
