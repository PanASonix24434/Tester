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
        Schema::table('appeals', function (Blueprint $table) {
            if (!Schema::hasColumn('appeals', 'ppl_comments')) $table->text('ppl_comments')->nullable();
            if (!Schema::hasColumn('appeals', 'kcl_comments')) $table->text('kcl_comments')->nullable();
            if (!Schema::hasColumn('appeals', 'pk_comments')) $table->text('pk_comments')->nullable();
            if (!Schema::hasColumn('appeals', 'kpp_decision')) $table->string('kpp_decision')->nullable();
            if (!Schema::hasColumn('appeals', 'kpp_comments')) $table->text('kpp_comments')->nullable();
            if (!Schema::hasColumn('appeals', 'kpp_ref_no')) $table->string('kpp_ref_no')->nullable();
            if (!Schema::hasColumn('appeals', 'decision_letter_path')) $table->string('decision_letter_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->dropColumn([
                'ppl_comments', 'kcl_comments', 'pk_comments',
                'kpp_decision', 'kpp_comments', 'kpp_ref_no', 'decision_letter_path'
            ]);
        });
    }
};
