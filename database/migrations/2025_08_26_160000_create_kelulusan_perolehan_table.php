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

        // Alter existing permits table to work with new structure
        Schema::table('permits', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['permit_number', 'permit_type', 'zone', 'issue_date', 'expiry_date', 'has_progress', 'application_count']);
            
            // Add new columns
            $table->string('no_permit')->unique()->after('id'); // 112341, 112342, etc.
            $table->unsignedBigInteger('kelulusan_perolehan_id')->after('no_permit');
            $table->string('jenis_peralatan')->after('kelulusan_perolehan_id'); // Pukat Hanyut, Pukat Tunda, Rawai
            $table->enum('status', ['ada_kemajuan', 'tiada_kemajuan'])->default('tiada_kemajuan')->after('jenis_peralatan');
            $table->boolean('is_active')->default(true)->after('status');
            
            // Add foreign key
            $table->foreign('kelulusan_perolehan_id')->references('id')->on('kelulusan_perolehan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert permits table to old structure
        Schema::table('permits', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['kelulusan_perolehan_id']);
            
            // Drop new columns
            $table->dropColumn(['no_permit', 'kelulusan_perolehan_id', 'jenis_peralatan', 'is_active']);
            
            // Add back old columns
            $table->string('permit_number')->after('id');
            $table->string('permit_type')->after('permit_number');
            $table->string('zone')->after('permit_type');
            $table->date('issue_date')->after('zone');
            $table->date('expiry_date')->after('issue_date');
            $table->boolean('has_progress')->after('expiry_date');
            $table->integer('application_count')->after('has_progress');
        });
        
        Schema::dropIfExists('kelulusan_perolehan');
    }
};
