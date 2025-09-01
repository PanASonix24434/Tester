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
        Schema::table('nelayan_marins', function (Blueprint $table) {
            // Add the 'kru_application_kru_id' column and foreign key constraint
            $table->uuid('kru_application_kru_id')->nullable();
            $table->foreign('kru_application_kru_id')->references('id')->on('kru_application_krus');

            // Add the 'kru_position_id' column and foreign key constraint
            $table->uuid('kru_position_id')->nullable();
            $table->foreign('kru_position_id')->references('id')->on('code_masters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nelayan_marins', function (Blueprint $table) {
            // Drop foreign key constraints before dropping columns
            $table->dropForeign(['kru_application_kru_id']);
            $table->dropForeign(['kru_position_id']);

            // Drop the columns
            $table->dropColumn('kru_application_kru_id');
            $table->dropColumn('kru_position_id');
        });
    }
};
