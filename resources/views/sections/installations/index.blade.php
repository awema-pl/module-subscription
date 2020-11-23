@extends('indigo-layout::installation')

@section('meta_title', _p('subscription::pages.installation.meta_title', 'Installation subscription') . ' - ' . config('app.name'))
@section('meta_description', _p('subscription::pages.installation.meta_description', 'Installation subscription in application'))

@push('head')

@endpush

@section('title')
    <h2>{{ _p('subscription::pages.installation.headline', 'Installation subscription') }}</h2>
@endsection

@section('content')
    <form-builder disabled-dialog="" url="{{ route('subscription.installation.index') }}" send-text="{{ _p('subscription::pages.installation.send_text', 'Install') }}"
    edited>
        <div class="section">
            <ul>
                <li>
                    {{ _p('subscription::pages.installation.will_be_execute_migrations', 'Will be execute package migrations') }}
                </li>
            </ul>
        </div>
    </form-builder>
@endsection
