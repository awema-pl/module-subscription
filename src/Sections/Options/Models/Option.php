<?php

namespace AwemaPL\Subscription\Sections\Options\Models;

use Illuminate\Database\Eloquent\Model;
use AwemaPL\Subscription\Sections\Options\Models\Contracts\Option as OptionContract;

class Option extends Model implements OptionContract
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('subscription.database.tables.options');
    }


}
