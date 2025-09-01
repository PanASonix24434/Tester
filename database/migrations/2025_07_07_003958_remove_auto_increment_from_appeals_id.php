<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove AUTO_INCREMENT from id column
        DB::statement('ALTER TABLE appeals MODIFY id CHAR(36) NOT NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If you want to revert, you may need to set it back to int AUTO_INCREMENT (not recommended for UUIDs)
        // DB::statement('ALTER TABLE appeals MODIFY id INT NOT NULL AUTO_INCREMENT;');
    }
};
