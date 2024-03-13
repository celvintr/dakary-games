<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('assigned_card_details', function (Blueprint $table) {
            $table->string('dealer_code', 6)->nullable()->after('status');
        });

        $details = DB::table('assigned_card_details')->get();
        foreach ($details as $detail) {
            $assigned = DB::table('assigned_cards')->where('id', $detail->assigned_card_id)->first();
            $dealer = DB::table('dealers')->where('id', $assigned->dealer_id)->first();

            $affected = DB::table('assigned_card_details')
                ->where('id', $detail->id)
                ->update(['dealer_code' => $dealer->code]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assigned_card_details', function (Blueprint $table) {
            //
        });
    }
};
