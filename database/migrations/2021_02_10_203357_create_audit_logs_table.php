<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('table_id')->nullable();
            $table->string('source')->nullable();
            $table->string('action')->nullable();
            $table->json('details')->nullable();
            $table->text('exception')->nullable();
            $table->string('ip_address', 50)->nullable();

            $table->string('browser')->nullable();
            $table->string('browser_family', 150)->nullable();
            $table->string('browser_version', 50)->nullable();
            $table->string('browser_engine', 150)->nullable();

            $table->string('platform')->nullable();
            $table->string('platform_family', 150)->nullable();
            $table->string('platform_version', 50)->nullable();

            $table->string('device_type', 20)->nullable();
            $table->string('device_family', 150)->nullable();
            $table->string('device_model', 150)->nullable();

            $table->string('mobile_grade', 10)->nullable();

            $table->boolean('is_bot');
            $table->boolean('is_in_app');

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}
