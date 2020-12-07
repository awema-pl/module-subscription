<?php

namespace AwemaPL\Subscription\Listeners;

use AwemaPL\Auth\Facades\Auth as AwemaAuth;
use AwemaPL\Auth\Sections\Tokens\Models\PlainToken;
use AwemaPL\Chromator\Sections\Tokens\Models\Token;
use AwemaPL\Subscription\Sections\Memberships\Models\Membership;
use AwemaPL\Subscription\Sections\Options\Models\Option;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Log;

class EventSubscriber
{
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Registered',
            static::class.'@handleRegistered'
        );
    }

    public function handleRegistered($event)
    {
       try{
           $user = $event->user;
           if (!$user->membership){
               $option = Option::firstOrCreate(['name' =>config('subscription.trial_option_name')], ['price'=>0.0]);
               $expiresAt = now();
               $expiresAt->addDays(config('subscription.trial_days'));
               Membership::create([
                   'expires_at' =>$expiresAt,
                   'user_id' =>$user->id,
                   'option_id' =>$option->id,
               ]);
           }
       } catch (\Exception $e){
           Log::error($e->getMessage(), $e->getTrace());
       }
    }
}
