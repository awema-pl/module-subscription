@extends('indigo-layout::main')

@section('meta_title', _p('subscription::pages.membership.meta_title', 'Memberships') . ' - ' . config('app.name'))
@section('meta_description', _p('subscription::pages.membership.meta_description', 'Memberships in application'))

@push('head')

@endpush

@section('title')
    {{ _p('subscription::pages.membership.headline', 'Memberships') }}
@endsection

@section('create_button')
    <button class="frame__header-add" @click="AWEMA.emit('modal::create:open')" title="{{ _p('subscription::pages.membership.create_membership', 'Create membership') }}"><i class="icon icon-plus"></i></button>
@endsection

@section('content')
    <div class="grid">
        <div class="cell-1-1 cell--dsm">
            <h4>{{ _p('subscription::pages.membership.memberships', 'Membership') }}</h4>
            <div class="card">
                <div class="card-body">
                    <content-wrapper :url="$url.urlFromOnlyQuery('{{ route('subscription.membership.scope')}}', ['page', 'limit'], $route.query)"
                        :check-empty="function(test) { return !(test && (test.data && test.data.length || test.length)) }"
                        name="memberships_table">
                        <template slot-scope="table">
                            <table-builder :default="table.data">
                                <tb-column name="user" label="{{ _p('subscription::pages.membership.user', 'User') }}">
                                    <template slot-scope="col">
                                        @{{ col.data.user.email }}
                                    </template>
                                </tb-column>
                                <tb-column name="option" label="{{ _p('subscription::pages.membership.option', 'Option') }}">
                                    <template slot-scope="col">
                                        @{{ col.data.option.name }}
                                    </template>
                                </tb-column>
                               <tb-column name="expires_at" label="{{ _p('subscription::pages.membership.expiration_date', 'Expiration date') }}">
                                   <template slot-scope="col">
                                       <template v-if="col.data.has_expired">
                                           <s class="cl-red">@{{ col.data.expires_at }}</s>
                                       </template>
                                       <template v-if="!col.data.has_expired">
                                           @{{ col.data.expires_at }}
                                       </template>
                                   </template>
                               </tb-column>
                                <tb-column name="comment" label="{{ _p('subscription::pages.membership.comment', 'Comment') }}">
                                    <template slot-scope="col">
                                        @{{ AWEMA.utils.lodash.truncate(col.data.comment, {omission: '...'}) }}
                                    </template>
                                </tb-column>
                                <tb-column name="created_at" label="{{ _p('subscription::pages.membership.created_at', 'Created at') }}"></tb-column>
                                <tb-column name="manage" label="{{ _p('subscription::pages.membership.options', 'Options')  }}">
                                    <template slot-scope="col">
                                        <context-menu right boundary="table">
                                            <button type="submit" slot="toggler" class="btn">
                                                {{_p('subscription::pages.membership.options', 'Options')}}
                                            </button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'editMembership', data: col.data}); AWEMA.emit('modal::edit_membership:open')">
                                                {{_p('subscription::pages.membership.edit', 'Edit')}}
                                            </cm-button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'deleteMembership', data: col.data}); AWEMA.emit('modal::delete_membership:open')">
                                                {{_p('subscription::pages.membership.delete', 'Delete')}}
                                            </cm-button>
                                        </context-menu>
                                    </template>
                                </tb-column>
                            </table-builder>

                            <paginate-builder v-if="table.data"
                                :meta="table.meta"
                            ></paginate-builder>
                        </template>
                        @include('indigo-layout::components.base.loading')
                        @include('indigo-layout::components.base.empty')
                        @include('indigo-layout::components.base.error')
                    </content-wrapper>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <modal-window name="create" class="modal_formbuilder" title="{{ _p('subscription::pages.membership.create_membership', 'Create membership') }}">
        <form-builder url="{{ route('subscription.membership.store') }}" @sended="AWEMA.emit('content::memberships_table:update')">
            <div class="grid">
                <div class="cell">
                    <fb-select name="user_id" :multiple="false" url="{{ route('subscription.membership.scope_users') }}?q=%s" open-fetch options-value="id" options-name="email"
                               label="{{ _p('subscription::pages.membership.select_user', 'Select user') }}">
                    </fb-select>
                    <fb-select name="option_id" :multiple="false" url="{{ route('subscription.option.scope') }}?q=%s" open-fetch options-value="id" options-name="name"
                               label="{{ _p('subscription::pages.membership.select_option', 'Select option') }}">
                    </fb-select>
                    <fb-date name="expires_at" format="YYYY-MM-DD HH:mm:ss" label="{{ _p('subscription::pages.membership.expiration_date', 'Expiration date') }}"></fb-date>
                    <fb-textarea name="comment" label="{{ _p('subscription::pages.membership.comment', 'Comment') }}"></fb-textarea>
                </div>
            </div>
        </form-builder>
    </modal-window>

    <modal-window name="edit_membership" class="modal_formbuilder" title="{{ _p('subscription::pages.membership.edit_membership', 'Edit membership') }}">
        <form-builder url="{{ route('subscription.membership.update') }}/{id}" method="patch"
                      @sended="AWEMA.emit('content::memberships_table:update')"
                      send-text="{{ _p('subscription::pages.membership.save', 'Save') }}" store-data="editMembership">
            <div class="grid" v-if="AWEMA._store.state.editMembership">
                <div class="cell">
                    <fb-select name="user_id" :multiple="false" url="{{ route('subscription.membership.scope_users') }}?q=%s" auto-fetch options-value="id" options-name="email"
                               label="{{ _p('subscription::pages.membership.select_user', 'Select user') }}"
                               :auto-fetch-name="AWEMA._store.state.editMembership.user.email" :auto-fetch-value="AWEMA._store.state.editMembership.user.id">
                    </fb-select>
                    <fb-select name="option_id" :multiple="false" url="{{ route('subscription.option.scope') }}?q=%s" auto-fetch options-value="id" options-name="name"
                               label="{{ _p('subscription::pages.membership.select_option', 'Select option') }}"
                               :auto-fetch-name="AWEMA._store.state.editMembership.option.name" :auto-fetch-value="AWEMA._store.state.editMembership.option.id">
                    </fb-select>
                    <fb-date name="expires_at" format="YYYY-MM-DD HH:mm:ss" label="{{ _p('subscription::pages.membership.expiration_date', 'Expiration date') }}"></fb-date>
                    <fb-textarea name="comment" label="{{ _p('subscription::pages.membership.comment', 'Comment') }}"></fb-textarea>
                </div>
            </div>
        </form-builder>
    </modal-window>

    <modal-window name="delete_membership" class="modal_formbuilder" title="{{  _p('subscription::pages.membership.are_you_sure_delete', 'Are you sure delete?') }}">
        <form-builder :edited="true" url="{{route('subscription.membership.delete') }}/{id}" method="delete"
                      @sended="AWEMA.emit('content::memberships_table:update')"
                      send-text="{{ _p('subscription::pages.membership.confirm', 'Confirm') }}" store-data="deleteMembership"
                      disabled-dialog>

        </form-builder>
    </modal-window>
@endsection
