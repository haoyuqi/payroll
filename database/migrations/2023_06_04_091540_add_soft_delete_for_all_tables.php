<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['departments', 'employees', 'paychecks', 'time_logs'];

        try {
            foreach ($tables as $table) {
                Schema::table($table, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        } catch (\Exception $e) {
            throw new LogicException($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = ['departments', 'employees', 'paychecks', 'time_logs'];

        try {
            foreach ($tables as $table) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        } catch (\Exception $e) {
            throw new LogicException($e->getMessage());
        }
    }
};
