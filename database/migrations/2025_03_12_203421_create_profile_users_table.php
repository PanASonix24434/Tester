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
        // Check if the table exists before creating it
        if (!Schema::hasTable('profile_users')) {
            Schema::create('profile_users', function (Blueprint $table) {
                $table->uuid('id')->primary(); // Primary key
                $table->uuid('user_id');
                $table->string('name');
                $table->string('icno');
                $table->text('address1')->nullable();
                $table->text('address2')->nullable();
                $table->text('address3')->nullable();
                $table->integer('poskod')->nullable();
                $table->string('district')->nullable();
                $table->string('state')->nullable();
                $table->integer('age')->nullable();
                $table->string('gender')->nullable();
                $table->string('user_type');
                $table->string('no_phone');
                $table->string('no_phone_office')->nullable();
                $table->string('religion')->nullable();
                $table->string('race')->nullable();
                $table->string('wedding_status')->nullable();
                $table->string('email');
                $table->string('salinan_ic')->nullable();
                $table->string('no_vesel')->nullable();
                $table->string('document')->nullable();
                $table->integer('is_active');
                $table->integer('oku_status')->nullable();
                $table->integer('bumiputera_status')->nullable();
                $table->uuid('created_by')->nullable();
                $table->uuid('updated_by')->nullable();
                $table->uuid('deleted_by')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_users');
    }
};
