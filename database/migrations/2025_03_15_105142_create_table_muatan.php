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
        if (!Schema::hasTable('muatan')) {
            Schema::create('muatan', function (Blueprint $table) {
                $table->id(); // Auto-increment PK
                $table->uuid('kulit_id'); // FK to UUID
                $table->string('gt_1');
                $table->string('gt_2');
                $table->string('grt_1');
                $table->string('grt_2');
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                // Foreign key constraint
                $table->foreign('kulit_id')
                    ->references('id')->on('kulit')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muatan');
    }
};
