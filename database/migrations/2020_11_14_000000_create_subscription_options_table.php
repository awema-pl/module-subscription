
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionOptionsTable extends Migration
{
    public function up()
    {
        Schema::create(config('subscription.database.tables.options'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(config('subscription.database.tables.options'));
    }
}
