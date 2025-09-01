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
        Schema::table('profile_pentadbir_hartas', function (Blueprint $table) {
            //$table->dropForeign(['user_id']);
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('name')->nullable()->after('user_id');
            $table->string('icno')->nullable()->after('name');
            $table->text('address')->nullable()->after('icno');
            $table->string('phone')->nullable()->after('address');
            $table->string('email')->nullable()->after('phone');
            $table->foreignUuid('vessel_owner_id')->nullable()->after('email')->constrained('profile_users');
            $table->foreignUuid('vessel_id')->nullable()->after('no_vesel')->constrained();
            $table->string('dokumen_sokongan_3')->nullable()->after('dokumen_sokongan_2');
            $table->string('dokumen_sokongan_4')->nullable()->after('dokumen_sokongan_3');
            $table->string('status')->nullable()->after('dokumen_sokongan_4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_pentadbir_hartas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            // $table->foreign('user_id')->references('id')->on('profile_users')->onDelete('cascade');

            $table->dropForeign(['vessel_owner_id']);
            $table->dropForeign(['vessel_id']);
            $table->dropColumn([
                'name',
                'icno',
                'address',
                'phone',
                'email',
                'vessel_owner_id',
                'vessel_id',
                'dokumen_sokongan_3',
                'dokumen_sokongan_4',
                'status',
            ]);
        });
    }
};
