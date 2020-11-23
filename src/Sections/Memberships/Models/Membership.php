<?php

namespace AwemaPL\Subscription\Sections\Memberships\Models;

use AwemaPL\Subscription\Sections\Options\Models\Option;
use Illuminate\Database\Eloquent\Model;
use AwemaPL\Subscription\Sections\Memberships\Models\Contracts\Membership as MembershipContract;

class Membership extends Model implements MembershipContract
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expires_at', 'comment', 'user_id', 'option_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'option_id' => 'integer'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('subscription.database.tables.memberships');
    }

    /**
     * Get the user that owns the membership.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * Get the option record associated with the membership.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option(){
        return $this->belongsTo(Option::class);
    }
}
