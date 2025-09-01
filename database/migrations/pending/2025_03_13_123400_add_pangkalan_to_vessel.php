<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('vessels', function (Blueprint $table) {
            $table->foreignId('pangkalan_utama_id')->nullable()->constrained('am_pangkalan')->onDelete('set null');
            $table->foreignId('pangkalan_tambahan_id')->nullable()->constrained('am_pangkalan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('vessels', function (Blueprint $table) {
            $table->dropForeign(['pangkalan_utama_id']);
            $table->dropForeign(['pangkalan_tambahan_id']);
            $table->dropColumn(['pangkalan_utama_id', 'pangkalan_tambahan_id']);
        });
    }
};
