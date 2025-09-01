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
        Schema::table('vessels', function (Blueprint $table) {
            // Dropping unwanted columns
            $table->dropColumn(['zone', 'vessel_no', 'start_date', 'end_date']);

            // Adding new vessel details
            $table->string('no_pendaftaran')->after('id')->unique();  // No. Pendaftaran Vesel
            $table->string('negeri')->after('no_pendaftaran');  // Negeri
            $table->string('daerah')->after('negeri');  // Daerah
            $table->string('pangkalan')->after('daerah');  // Pangkalan
            $table->string('zon')->after('pangkalan');  // Bil. Enjin
            $table->unsignedInteger('bil_enjin')->nullable()->after('zon'); // Bil. Enjin
            $table->dateTime('tarikh_mula')->nullable()->after('bil_enjin');  // Tarikh Mula
            $table->dateTime('tarikh_tamat_lesen')->nullable()->after('tarikh_mula');  // Tarikh Tamat Lesen
            $table->boolean('status_vesel')->default(true)->after('tarikh_tamat_lesen'); // Status Vesel

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vessels', function (Blueprint $table) {
            // Adding back the dropped columns
            $table->string('zone')->nullable()->after('id');
            $table->string('vessel_no')->after('zone');
            $table->dateTime('start_date')->nullable()->after('vessel_no');
            $table->dateTime('end_date')->nullable()->after('start_date');

            // Dropping the newly added columns
            $table->dropColumn([
                'no_pendaftaran',
                'negeri',
                'daerah',
                'pangkalan',
                'bil_enjin',
                'tarikh_mula',
                'tarikh_tamat_lesen',
                'status_vesel',
                'zon',
            ]);
        });
    }
};
