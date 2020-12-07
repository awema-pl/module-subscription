<div class="cell-1-2 cell--dsm">
    <h4>{{ _p('subscription::pages.widget.membership.subscription', 'Subscription') }}</h4>
    <div class="card">
        <div class="card-body">
            <h5>{{ _p('subscription::pages.widget.membership.information_access', 'Information on access to :appName services.', ['appName' =>config('app.name')]) }}</h5>
            @if($membership = Auth::user()->membership)
                <p>
                    {{ _p('subscription::pages.widget.membership.your_subscription', 'Your subscription') }}:

                    <span class="badge badge_grass ml-5">{{ _p('subscription::pages.widget.membership.' .mb_strtolower($membership->option->name), $membership->option->name) }}</span>
                </p>
                @if(now()<=$membership->expires_at)
                    <p class="mb-0">
                        {{ _p('subscription::pages.widget.membership.days_left_until_expiry', 'Days left until expiry') }}:
                        <span class="badge badge_grass ml-5">{{$membership->expires_at->diffInDays(now())}}</span>
                        <span class="cl-green ml-5">{{$membership->expires_at->format('Y-m-d H:i:s')}}</span>
                    </p>
                @else
                    <p class="mb-0">
                        {{ _p('subscription::pages.widget.membership.subscription_has_expired', 'Subscription has expired') }}:
                        <strong class="cl-red">{{$membership->expires_at->format('Y-m-d H:i:s')}}</strong>
                    </p>
                @endif
            @else
                <span class="cl-red">{{ _p('subscription::pages.widget.membership.no_subscription', 'No subscription') }}</span>
            @endif
        </div>
    </div>
</div>
