<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyListTableAddMinMax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('list', function(Blueprint $table) {
            $table->integer('min')->default(0)->after('title');
            $table->integer('max')->default(999)->after('min');
        });

        DB::statement("UPDATE list SET max = duration");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('list', function(Blueprint $table) {
            $table->dropColumn('min');
            $table->dropColumn('max');
        });
    }
}
