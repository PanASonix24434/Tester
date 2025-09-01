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
        Schema::create('kelulusan_perolehan', function (Blueprint $table) {
            $table->id();
            $table->string('no_rujukan')->unique(); // PPKPV01-923, PPKPV02-512, etc.
            $table->string('jenis_permohonan'); // kvp07, kvp08, etc.
            $table->string('status')->default('active'); // active, inactive, expired
            $table->date('tarikh_kelulusan');
            $table->date('tarikh_tamat');
            $table->string('user_id'); // applicant who owns this approval
            $table->timestamps();
        });

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
        Schema::dropIfExists('kelulusan_perolehan');
    }
};
