
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionMembershipsTable extends Migration
{
    public function up()
    {
        Schema::create(config('subscription.database.tables.memberships'), function (Blueprint $table) {
            $table->id();
            $table->dateTime('expires_at');
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::table(config('subscription.database.tables.memberships'), function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained(config('subscription.database.tables.users'))
                ->onDelete('cascade');
            $table->foreignId('option_id')
                ->constrained(config('subscription.database.tables.options'))
                ->onDelete('cascade');
        });

        Schema::table(config('subscription.database.tables.memberships'), function (Blueprint $table) {
            $table->unique(['user_id']);
        });
    }

    public function down()
    {
        Schema::table(config('subscription.database.tables.memberships'), function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });

        Schema::table(config('subscription.database.tables.memberships'), function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::drop(config('subscription.database.tables.memberships'));
    }
}
