@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.cms.pages.add-title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.cms.store') }}" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.cms.index') }}'"></i>

                        {{ __('admin::app.cms.pages.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.cms.pages.create-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()

                    {!! view_render_event('bagisto.admin.cms.pages.create_form_accordian.general.before') !!}

                    <accordian :title="'{{ __('admin::app.cms.pages.general') }}'" :active="true">
                        <div slot="body">
                        <div class="control-group" :class="[errors.has('category_id') ? 'has-error' : '']">
                                <label for="category_id" >Page Category</label>
                                <select name="category_id"  id="cate_id"></select>
                            </div>
                            <div class="control-group" :class="[errors.has('page_title') ? 'has-error' : '']">
                                <label for="page_title" class="required">{{ __('admin::app.cms.pages.page-title') }}</label>

                                <input type="text" class="control" name="page_title" v-validate="'required'" value="{{ old('page_title') }}" data-vv-as="&quot;{{ __('admin::app.cms.pages.page-title') }}&quot;">

                                <span class="control-error" v-if="errors.has('page_title')">@{{ errors.first('page_title') }}</span>
                            </div>

                            @inject('channels', 'Webkul\Core\Repositories\ChannelRepository')

                            <div class="control-group" :class="[errors.has('channels[]') ? 'has-error' : '']">
                                <label for="url-key" class="required">{{ __('admin::app.cms.pages.channel') }}</label>

                                <select type="text" class="control" name="channels[]" v-validate="'required'" value="{{ old('channel[]') }}" data-vv-as="&quot;{{ __('admin::app.cms.pages.channel') }}&quot;" multiple="multiple">
                                    @foreach($channels->all() as $channel)
                                        <option value="{{ $channel->id }}">{{ core()->getChannelName($channel) }}</option>
                                    @endforeach
                                </select>

                                <span class="control-error" v-if="errors.has('channels[]')">@{{ errors.first('channels[]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('html_content') ? 'has-error' : '']">
                                <label for="html_content" class="required">{{ __('admin::app.cms.pages.content') }}</label>

                                <textarea type="text" class="control" id="content" name="html_content" v-validate="'required'" data-vv-as="&quot;{{ __('admin::app.cms.pages.content') }}&quot;">{{ old('html_content') }}</textarea>

                                <span class="control-error" v-if="errors.has('html_content')">@{{ errors.first('html_content') }}</span>
                            </div>
                        </div>
                    </accordian>

                    {!! view_render_event('bagisto.admin.cms.pages.create_form_accordian.general.after') !!}


                    {!! view_render_event('bagisto.admin.cms.pages.create_form_accordian.seo.before') !!}

                    <accordian :title="'{{ __('admin::app.cms.pages.seo') }}'" :active="true">
                        <div slot="body">


                            <div class="control-group">
                                <label for="meta_title">{{ __('admin::app.cms.pages.meta_title') }}</label>

                                <input type="text" class="control" name="meta_title" value="{{ old('meta_title') }}">
                            </div>

                            <div class="control-group" :class="[errors.has('url_key') ? 'has-error' : '']">
                                <label for="url-key" class="required">{{ __('admin::app.cms.pages.url-key') }}</label>

                                <input type="text" class="control" name="url_key" v-validate="'required'" value="{{ old('url_key') }}" data-vv-as="&quot;{{ __('admin::app.cms.pages.url-key') }}&quot;" v-slugify>

                                <span class="control-error" v-if="errors.has('url_key')">@{{ errors.first('url_key') }}</span>
                            </div>

                            <div class="control-group">
                                <label for="meta_keywords">{{ __('admin::app.cms.pages.meta_keywords') }}</label>

                                <textarea type="text" class="control" name="meta_keywords">{{ old('meta_keywords') }}</textarea>
                            </div>

                            <div class="control-group">
                                <label for="meta_description">{{ __('admin::app.cms.pages.meta_description') }}</label>

                                <textarea type="text" class="control" name="meta_description">{{ old('meta_description') }}</textarea>

                            </div>
                        </div>
                    </accordian>

                    {!! view_render_event('bagisto.admin.cms.pages.create_form_accordian.seo.after') !!}
                </div>
            </div>
        </form>
    </div>
@stop
<script>
var categoriesdata = [];
function getCategories(requestURL){
   var table_content='';
   if(requestURL=='')requestURL = "{{ url('/') }}/api/pages/category/get-list?token=true&limit=1000";
   
        console.log("get_pages_categories : "+requestURL);

        var checkCall = $.ajax({
            url: requestURL,
            dataType: 'json',
            type: 'get',
            contentType: 'application/json',
            headers: {
                'Accept':'application/json',
                //'Authorization':'Bearer ' + '***...',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: null,
            processData: false,
            beforeSend: function() { },
            success: function( data, textStatus, jQxhr ){
                categoriesdata=data.data;
                var category_options='<option value="0">None</option>';
                for(i=0;i<categoriesdata.length;i++)category_options +='<option value="'+categoriesdata[i]["id"]+'">'+categoriesdata[i]["cate_name"]+"</option>";
                //console.log( "category_options "+category_options );
                $("#cate_id").html(category_options);
       
                    console.log("get_pages_categories() data  : " + JSON.stringify(data));
            },
            error: function( jqXhr, textStatus, errorThrown ){
                    console.log( "Error Thrown get_pages_categories : "+errorThrown );
            }
        });

	 }

   
    </script>


@push('scripts')
    @include('admin::layouts.tinymce')

    <script>
        $(document).ready(function () {
            tinyMCEHelper.initTinyMCE({
                selector: 'textarea#content',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor alignleft aligncenter alignright alignjustify | link hr |numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true,
                valid_elements : '*[*]',
                uploadRoute: '{{ route('admin.tinymce.upload') }}',
                csrfToken: '{{ csrf_token() }}',
            });
        });

        $(document).ready(function() {
        getCategories('');
    } );
    </script>
@endpush
