@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.leads.create-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('admin.leads.create.header.before') !!}

        <div class="page-header">

            {{ Breadcrumbs::render('leads.create') }}

            <div class="page-title">
                <h1>{{ __('admin::app.leads.create-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('admin.leads.create.header.after') !!}

        <form method="POST" action="{{ route('admin.leads.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('admin.leads.create.form_buttons.before') !!}

                            <button type="submit" class="btn btn-md btn-primary">
                                {{ __('admin::app.leads.save-btn-title') }}
                            </button>

                            <a href="{{ route('admin.leads.index') }}">{{ __('admin::app.leads.back') }}</a>

                            {!! view_render_event('admin.leads.create.form_buttons.after') !!}
                        </div>
        
                        {!! view_render_event('admin.leads.create.form_controls.before') !!}

                        @csrf()
                        
                        <input type="hidden" id="lead_stage_id" name="lead_stage_id" value="1" />

                        <tabs>
                            {!! view_render_event('admin.leads.create.form_controls.details.before') !!}

                            <tab name="{{ __('admin::app.leads.details') }}" :selected="true">
                                @include('admin::common.custom-attributes.edit', [
                                    'customAttributes' => app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                        'entity_type' => 'leads',
                                        'quick_add'   => 1
                                    ]),
                                ])
                            </tab>

                            {!! view_render_event('admin.leads.create.form_controls.details.after') !!}


                            {!! view_render_event('admin.leads.create.form_controls.contact_person.before') !!}

                            <tab name="{{ __('admin::app.leads.contact-person') }}">
                                @include('admin::leads.common.contact')

                                <contact-component></contact-component>
                            </tab>

                            {!! view_render_event('admin.leads.create.form_controls.contact_person.after') !!}


                            {!! view_render_event('admin.leads.create.form_controls.products.before') !!}

                            <tab name="{{ __('admin::app.leads.products') }}">
                                @include('admin::leads.common.products')

                                <product-list></product-list>
                            </tab>

                            {!! view_render_event('admin.leads.create.form_controls.products.after') !!}
                        </tabs>

                        {!! view_render_event('admin.leads.create.form_controls.after') !!}

                    </div>

                </div>

            </div>

        </form>

    </div>
@stop