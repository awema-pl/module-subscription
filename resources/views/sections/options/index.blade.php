@extends('indigo-layout::main')

@section('meta_title', _p('subscription::pages.option.meta_title', 'Options') . ' - ' . config('app.name'))
@section('meta_description', _p('subscription::pages.option.meta_description', 'Options in application'))

@push('head')

@endpush

@section('title')
    {{ _p('subscription::pages.option.headline', 'Options') }}
@endsection

@section('create_button')
    <button class="frame__header-add" @click="AWEMA.emit('modal::create:open')" title="{{ _p('subscription::pages.option.create_option', 'Create option') }}"><i class="icon icon-plus"></i></button>
@endsection

@section('content')
    <div class="grid">
        <div class="cell-1-1 cell--dsm">
            <h4>{{ _p('subscription::pages.option.options', 'Option') }}</h4>
            <div class="card">
                <div class="card-body">
                    <content-wrapper :url="$url.urlFromOnlyQuery('{{ route('subscription.option.scope')}}', ['page', 'limit'], $route.query)"
                        :check-empty="function(test) { return !(test && (test.data && test.data.length || test.length)) }"
                        name="options_table">
                        <template slot-scope="table">
                            <table-builder :default="table.data">
                                <tb-column name="name" label="{{ _p('subscription::pages.option.name', 'Name') }}"></tb-column>
                                <tb-column name="price_format" label="{{ _p('subscription::pages.option.price', 'Price') }}">
                                    <template slot-scope="col">
                                        @{{ col.data.price.toFixed(2) }}
                                    </template>
                                </tb-column>
                                <tb-column name="created_at" label="{{ _p('subscription::pages.option.created_at', 'Created at') }}"></tb-column>
                                <tb-column name="manage" label="{{ _p('subscription::pages.option.options', 'Options')  }}">
                                    <template slot-scope="col">
                                        <context-menu right boundary="table">
                                            <button type="submit" slot="toggler" class="btn">
                                                {{_p('subscription::pages.option.options', 'Options')}}
                                            </button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'editOption', data: col.data}); AWEMA.emit('modal::edit_option:open')">
                                                {{_p('subscription::pages.option.edit', 'Edit')}}
                                            </cm-button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'deleteOption', data: col.data}); AWEMA.emit('modal::delete_option:open')">
                                                {{_p('subscription::pages.option.delete', 'Delete')}}
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
    <content-window name="create" class="modal_formbuilder" title="{{ _p('subscription::pages.option.create_option', 'Create option') }}">
        <form-builder url="{{ route('subscription.option.store') }}" @sended="AWEMA.emit('content::options_table:update')">
            <div class="grid">
                <div class="cell">
                    <fb-input name="name" label="{{ _p('subscription::pages.option.name', 'Name') }}"></fb-input>
                    <fb-input name="price" type="number" label="{{ _p('subscription::pages.option.price', 'Price')}}"
                              min="0.00" max="99999999.99" step="0.01"></fb-input>
                </div>
            </div>
        </form-builder>
    </content-window>

    <content-window name="edit_option" class="modal_formbuilder" title="{{ _p('subscription::pages.option.edit_option', 'Edit option') }}">
        <form-builder url="{{ route('subscription.option.update') }}/{id}" method="patch"
                      @sended="AWEMA.emit('content::options_table:update')"
                      send-text="{{ _p('subscription::pages.option.save', 'Save') }}" store-data="editOption">
            <div class="grid" v-if="AWEMA._store.state.editOption">
                <div class="cell">
                    <fb-input name="name" label="{{ _p('subscription::pages.option.name', 'Name') }}"></fb-input>
                    <fb-input name="price" type="number" label="{{ _p('subscription::pages.option.price', 'Price')}}"
                              min="0.00" max="99999999.99" step="0.01"></fb-input>
                </div>
            </div>
        </form-builder>
    </content-window>

    <content-window name="delete_option" class="modal_formbuilder" title="{{  _p('subscription::pages.option.are_you_sure_delete', 'Are you sure delete?') }}">
        <form-builder :edited="true" url="{{route('subscription.option.delete') }}/{id}" method="delete"
                      @sended="AWEMA.emit('content::options_table:update')"
                      send-text="{{ _p('subscription::pages.option.confirm', 'Confirm') }}" store-data="deleteOption"
                      disabled-dialog>
                    <div class="text-center">
                        {{ _p('subscription::pages.option.all_memberships_for_this_option_will_be_delete', 'All memberships for this option will be delete.') }}
                    </div>
        </form-builder>
    </content-window>
@endsection
