<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertSubscriptionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table =config('subscription.database.tables.options');
        $subscriptions = config('subscription.database.insert_options');

        foreach ($subscriptions as $subscription){
            DB::table($table)->insert(
                [
                    'name' => $subscription['name'],
                    'price' => $subscription['price'],
                    'created_at' =>now(),
                ]
            );
        }
        if (config('subscription.use_trial')){
            DB::table($table)->insert(
                [
                    'name' => config('subscription.trial_option_name'),
                    'price' => 0.0,
                    'created_at' =>now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table =config('subscription.database.tables.options');
        $subscriptions = config('subscription.database.insert_options');

        foreach ($subscriptions as $subscription){
            DB::table($table)
                ->where('name', $subscription['name'])
                ->delete();
        }
        if (config('subscription.use_trial')){
            DB::table($table)
                ->where('name', config('subscription.trial_option_name'))
                ->delete();
        }
    }
}
