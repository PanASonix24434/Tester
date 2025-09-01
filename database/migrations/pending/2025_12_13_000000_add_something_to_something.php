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
        // Schema::table('vessels', function (Blueprint $table) {
        //     $table->boolean('is_active')->default(true);
            // $table->uuid('user_id'); // pemilik vesel
			// $table->foreign('user_id')->references('id')->on('users');
            // $table->float('grt')->nullable();
            // $table->uuid('peralatan_utama')->nullable();
			// $table->foreign('peralatan_utama')->references('id')->on('code_masters');
			// $table->dateTime('license_start')->nullable();
			// $table->dateTime('license_end')->nullable();
            // $table->string('zon')->nullable();
            // $table->string('no_pendaftaran')->unique()->nullable();
                // $table->dropColumn('zon');
                // $table->dropColumn('no_pendaftaran');
                // $table->renameColumn('zone', 'zon');
                // $table->renameColumn('vessel_no', 'no_pendaftaran');
        // });
        // Schema::table('kru_applications', function (Blueprint $table) {
            // $table->uuid('vessel_id')->nullable();
			// $table->foreign('vessel_id')->references('id')->on('vessels');
            // $table->uuid('decision_by')->nullable();
            // $table->foreign('decision_by')->references('id')->on('users');
			// $table->dateTime('decision_at')->nullable();
            // $table->string('application_type')->nullable();
            // $table->dropColumn('start_counting_at');
            // $table->dropColumn('registration_number');
            // $table->dropColumn('ssd_number');
            // $table->dropColumn('previous_ssd_number');
            // $table->datetime('start_counting_at')->nullable(); // date applicant send the application
            // $table->boolean('is_approved')->nullable();
        // });
        // Schema::table('kru_application_krus', function (Blueprint $table) {
        //     // $table->string('previous_ssd_number',10)->nullable();//ssd previous application
        //     // $table->uuid('kru_position_id')->nullable();
        //     // $table->foreign('kru_position_id')->references('id')->on('code_masters');
        //     // $table->uuid('race_id')->nullable();
        //     // $table->foreign('race_id')->references('id')->on('code_masters');
        //     // $table->uuid('kru_health_id')->nullable();
		// 	// $table->foreign('kru_health_id')->references('id')->on('code_masters');
		// 	// $table->string('health_declaration')->nullable(); //untuk kegunaan pembaharuan (KRU02)
        //     // $table->uuid('bumiputera_status_id')->nullable();
        //     // $table->foreign('bumiputera_status_id')->references('id')->on('code_masters');
        //     // $table->uuid('kewarganegaraan_status_id')->nullable();
        //     // $table->foreign('kewarganegaraan_status_id')->references('id')->on('code_masters');
		// 	$table->uuid('parliament_id')->nullable();
        //     $table->foreign('parliament_id')->references('id')->on('parliaments');//update
		// 	$table->uuid('parliament_seat_id')->nullable();
        //     $table->foreign('parliament_seat_id')->references('id')->on('parliament_seats');//update
        // });
        // Schema::table('nelayan_marins', function (Blueprint $table) {
            //     $table->uuid('race_id')->nullable();
            //     $table->foreign('race_id')->references('id')->on('code_masters');
            //     $table->dropColumn('registration_number');
            //     $table->uuid('kru_application_kru_id')->nullable();
            //     $table->foreign('kru_application_kru_id')->references('id')->on('kru_application_krus');
            //     $table->uuid('kru_position_id')->nullable();
            //     $table->foreign('kru_position_id')->references('id')->on('code_masters');
            // $table->dropForeign('nelayan_marins_vessel_id_foreign');
            // $table->dropColumn('vessel_id');
            // $table->uuid('vessel_id')->nullable();
			// $table->foreign('vessel_id')->references('id')->on('vessels');
            // $table->uuid('bumiputera_status_id')->nullable();
            // $table->foreign('bumiputera_status_id')->references('id')->on('code_masters');
            // $table->uuid('kewarganegaraan_status_id')->nullable();
            // $table->foreign('kewarganegaraan_status_id')->references('id')->on('code_masters');
		// 	$table->uuid('parliament_id')->nullable();
        //     $table->foreign('parliament_id')->references('id')->on('parliaments');//update
		// 	$table->uuid('parliament_seat_id')->nullable();
        //     $table->foreign('parliament_seat_id')->references('id')->on('parliament_seats');//update
        // });
        // Schema::table('kru_application_logs', function (Blueprint $table) {
        //     $table->dropColumn('checked');
        // });
        // Schema::table('foreign_crews', function (Blueprint $table) {
            // $table->uuid('vessel_id')->nullable();
			// $table->foreign('vessel_id')->references('id')->on('vessels');

			// $table->date('passport_end_date')->nullable();
            // $table->string('plks_number')->nullable();
			// $table->date('plks_end_date')->nullable();
			// $table->date('birth_date');
            // $table->uuid('gender_id');
            // $table->foreign('gender_id')->references('id')->on('code_masters');
            // $table->dropColumn('nationality');
            // $table->uuid('source_country_id')->nullable();
            // $table->foreign('source_country_id')->references('id')->on('code_masters');
            // $table->uuid('foreign_kru_position_id');
			// $table->foreign('foreign_kru_position_id')->references('id')->on('code_masters');
			// $table->string('crew_whereabout')->nullable();
            
            // $table->uuid('kru_application_foreign_kru_id')->nullable();
            // $table->foreign('kru_application_foreign_kru_id')->references('id')->on('kru_application_foreign_krus');
        // });
        // Schema::table('kru_application_foreign_krus', function (Blueprint $table) {
		// 	// $table->boolean('selected_for_approval')->nullable(); // untuk kegunaan ketika keputusan
		// 	// $table->boolean('has_plks')->nullable(); 
        //     // $table->dropColumn('source_country_id');
        //     // $table->uuid('source_country_id')->nullable();
        //     // $table->foreign('source_country_id')->references('id')->on('code_masters');
		// 	// $table->date('passport_end_date')->nullable();
		// 	// $table->date('plks_end_date')->nullable();
        //     // $table->string('plks_number')->nullable();
		// 	$table->boolean('supported')->nullable(); // untuk kegunaan ketika semakan
		// 	$table->boolean('approved')->nullable(); // untuk kegunaan ketika keputusan
        //     $table->string('revocation_reason')->nullable();
        // });
        // Schema::table('kru_application_foreigns', function (Blueprint $table) {
			// $table->boolean('selected_for_approval')->nullable(); // untuk kegunaan ketika keputusan
			// $table->boolean('has_plks')->nullable(); 
            // $table->dropColumn('source_country_id');
            // $table->uuid('source_country_id')->nullable();
            // $table->foreign('source_country_id')->references('id')->on('code_masters');
			// $table->date('passport_end_date')->nullable();
			// $table->date('plks_end_date')->nullable();
            // $table->string('plks_number')->nullable();
			// $table->boolean('supported')->nullable(); // untuk kegunaan ketika semakan
			// $table->boolean('approved')->nullable(); // untuk kegunaan ketika keputusan
            // $table->string('revocation_reason')->nullable();
        // });
        // Schema::table('kru_application_foreigns', function (Blueprint $table) {
        //     // $table->dropForeign(['immigration_gate_id']);
        //     // $table->dropColumn('immigration_gate_id');
		// 	$table->uuid('immigration_gate_id')->nullable();
		// 	// $table->foreign('immigration_gate_id')->references('id')->on('immigration_gates');
        // });
        // Schema::table('species', function (Blueprint $table) {
        //     $table->string('scientific_name')->nullable()->change();
        // });
        // Schema::table('landing_declaration_monthlies', function (Blueprint $table) {
            // $table->uuid('entity_id')->nullable();
            // $table->foreign('entity_id')->references('id')->on('entities');
            // $table->boolean('has_payed')->default(false);
        //     $table->datetime('submitted_at')->nullable(); // date applicant send the application
        // });
        // Schema::table('serial_numbers', function (Blueprint $table) {
            // $table->uuid('application_id')->nullable(); 
        //     $table->string('application_type')->nullable()->change();
        // });
        // Schema::table('darat_vessel_engines', function (Blueprint $table) {
        //     $table->dropUnique(['vessel_id']);
        // });
        // Schema::table('subsistence_payment_hqs', function (Blueprint $table) {
        //     $table->enum('status',['Dijana', 'Dicetak', 'Dihantar','Dilulus PBKP'])->change();
        // });
        // Schema::table('species', function (Blueprint $table) {
        //     $table->string('family_name')->nullable();
        //     $table->string('order_name')->nullable();
        // });
        // Schema::table('subsistence_payment_payees', function (Blueprint $table) {

        //     //status for monthly landing
        //     $table->boolean('has_landing')->default(false); // does the user have landing for the month
        //     $table->uuid('landing_monthly_id')->nullable(); //which landing it is referenced if any
        //     $table->foreign('landing_monthly_id')->references('id')->on('landing_declaration_monthlies');
        //     $table->boolean('in_process')->default(false); // does the landing in in used for other payment application?
        //     $table->boolean('have_paid')->default(false); // does the landing have been payed?
        // });
        // Schema::table('subsistence_application', function (Blueprint $table) {
		// 	$table->uuid('user_id');// applicant
		// 	$table->foreign('user_id')->references('id')->on('users');

        //     $table->string('address1')->nullable();
        //     $table->string('address2')->nullable();
        //     $table->string('address3')->nullable();
		// 	$table->string('postcode', 5)->nullable();
		// 	$table->string('city')->nullable();
		// 	$table->uuid('district_id')->nullable();
        //     $table->foreign('district_id')->references('id')->on('code_masters');//update
		// 	$table->uuid('state_id')->nullable();
        //     $table->foreign('state_id')->references('id')->on('code_masters');//update
            
        //     $table->string('contact_number')->nullable();

        //     $table->uuid('fisherman_type_id')->nullable();
        //     $table->foreign('fisherman_type_id')->references('id')->on('code_masters');
        //     $table->unsignedTinyInteger('working_days_fishing_per_month')->nullable();
            
        //     $table->datetime('submitted_at')->nullable(); // date applicant send the application
        // });
        //Schema::table('darat_user_fisherman_infos', function (Blueprint $table) {
        //    $table->uuid('fisherman_type_id')->nullable();
        //    $table->foreign('fisherman_type_id')->references('id')->on('code_masters')->onDelete('set null');
        //});
        //Schema::table('subsistence_application', function (Blueprint $table) {
        //    $table->integer('year_become_fisherman')->nullable();
        //    $table->integer('becoming_fisherman_duration')->nullable();
        //});
        //Schema::table('subsistence_list_quota', function (Blueprint $table) {
        //    $table->enum('status', ['Dijana', 'Dicetak', 'Dihantar','Selesai'])->default('Dijana')->change();
        //});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
