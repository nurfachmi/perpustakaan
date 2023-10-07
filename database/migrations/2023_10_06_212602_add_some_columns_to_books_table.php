<?php

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
        Schema::table('books', function (Blueprint $table) {
            $table->after('author', function (Blueprint $table) {
                $table->year('publish_year')->nullable();
                $table->text('description')->nullable()->comment('Sinopsis buku atau keterangan lain');
            });
            $table->string('isbn')->nullable()->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropUnique(['isbn']);
            $table->string('isbn')->nullable()->change();
            $table->dropColumn(['publish_year', 'description']);
        });
    }
};
