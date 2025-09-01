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
        Schema::create('permits_new', function (Blueprint $table) {
            $table->id();
            $table->string('no_permit')->unique(); // 112341, 112342, etc.
            $table->unsignedBigInteger('kelulusan_perolehan_id');
            $table->string('jenis_peralatan'); // Pukat Hanyut, Pukat Tunda, Rawai
            $table->enum('status', ['ada_kemajuan', 'tiada_kemajuan'])->default('tiada_kemajuan');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('kelulusan_perolehan_id')->references('id')->on('kelulusan_perolehan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permits_new');
    }
};
