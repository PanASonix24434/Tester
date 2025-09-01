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
        // Check if the 'vessels' table already exists
        if (!Schema::hasTable('vessels')) {
            Schema::create('vessels', function (Blueprint $table) {
                $table->uuid('id');
                $table->primary('id');
                $table->uuid('user_id'); // pemilik vesel
                $table->foreign('user_id')->references('id')->on('users');

                $table->string('zone')->nullable();
                $table->float('grt')->nullable();
                $table->uuid('peralatan_utama')->nullable();
                $table->foreign('peralatan_utama')->references('id')->on('code_masters');

                $table->string('vessel_no')->unique()->nullable();
                $table->date('license_start')->nullable();
                $table->date('license_end')->nullable();

                $table->uuid('entity_id');
                $table->foreign('entity_id')->references('id')->on('entities');
                $table->boolean('is_active')->default(true);

                $table->uuid('created_by')->nullable();
                $table->uuid('updated_by')->nullable();
                $table->uuid('deleted_by')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vesels');
    }
};
