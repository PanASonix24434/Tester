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
        Schema::create('applications_v2', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('entity_id')->nullable()->constrained();
            $table->string('type')->nullable();
            $table->string('ref')->nullable();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->auditField();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints if any exist
        DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('REFERENCED_TABLE_NAME', 'applications_v2')
            ->each(function ($foreignKey) {
                DB::statement('ALTER TABLE ' . $foreignKey->TABLE_NAME . ' DROP FOREIGN KEY ' . $foreignKey->CONSTRAINT_NAME);
            });

        // Now drop the table
        Schema::dropIfExists('applications_v2');
    }
};
