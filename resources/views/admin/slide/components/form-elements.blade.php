<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.slide.columns.title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.slide.columns.title') }}">
        <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
    </div>
</div>

<div class="card">
    @if($mode === 'edit')
        @include('brackets/admin-ui::admin.includes.media-uploader', [
            'mediaCollection' => $slide->getMediaCollection('cover'),
            'media' => $slide->getThumbs200ForCollection('cover'),
            'label' => 'photo'
        ])
    @else
        @include('brackets/admin-ui::admin.includes.media-uploader', [
            'mediaCollection' => app(App\Models\Slide::class)->getMediaCollection('cover'),
            'label' => 'photo'
        ])
    @endif
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('url'), 'has-success': fields.url && fields.url.valid }">
    <label for="url" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('url') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.url" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('url'), 'form-control-success': fields.url && fields.url.valid}" id="url" name="url" placeholder="{{ trans('url') }}">
        <div v-if="errors.has('url')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('url') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('active'), 'has-success': fields.active && fields.active.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="active" type="checkbox" v-model="form.active" v-validate="''" data-vv-name="active"  name="active_fake_element">
        <label class="form-check-label" for="active">
            {{ trans('admin.slide.columns.active') }}
        </label>
        <input type="hidden" name="active" :value="form.active">
        <div v-if="errors.has('active')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('active') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('updated'), 'has-success': fields.updated && fields.updated.valid }">
    <label for="updated" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.slide.columns.updated') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.updated" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('updated'), 'form-control-success': fields.updated && fields.updated.valid}" id="updated" name="updated" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('updated')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('updated') }}</div>
    </div>
</div>


