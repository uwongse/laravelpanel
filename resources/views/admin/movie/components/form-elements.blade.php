<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movie.columns.title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title"  class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.movie.columns.title') }}">
        <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('synopsis'), 'has-success': fields.synopsis && fields.synopsis.valid }">
    <label for="synopsis" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movie.columns.synopsis') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.synopsis"  id="synopsis" name="synopsis"></textarea>
        </div>
        <div v-if="errors.has('synopsis')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('synopsis') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('duration'), 'has-success': fields.duration && fields.duration.valid }">
    <label for="duration" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movie.columns.duration') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.duration"  class="form-control" :class="{'form-control-danger': errors.has('duration'), 'form-control-success': fields.duration && fields.duration.valid}" id="duration" name="duration" placeholder="{{ trans('admin.movie.columns.duration') }}">
        <div v-if="errors.has('duration')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('duration') }}</div>
    </div>
</div>



@if ($mode === 'create')
@include('brackets/admin-ui::admin.includes.media-uploader', [
    'mediaCollection' => app(App\Models\Movie::class)->getMediaCollection('backgrounds'),
    'label' => 'Backgrounds'
])
@include('brackets/admin-ui::admin.includes.media-uploader', [
    'mediaCollection' => app(App\Models\Movie::class)->getMediaCollection('posters'),
    'label' => 'Posters'
])
@else
@include('brackets/admin-ui::admin.includes.media-uploader', [
   'mediaCollection' => $movie->getMediaCollection('backgrounds'),
   'media' => $movie->getThumbs200ForCollection('backgrounds'),
   'label' => 'Backgrounds'
])
@include('brackets/admin-ui::admin.includes.media-uploader', [
    'mediaCollection' => $movie->getMediaCollection('posters'),
    'media' => $movie->getThumbs200ForCollection('posters'),
    'label' => 'Posters'
])

@endif

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date'), 'has-success': fields.date && fields.date.valid }">
    <label for="date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date" :config="datePickerConfig"  class="flatpickr" :class="{'form-control-danger': errors.has('date'), 'form-control-success': fields.date && fields.date.valid}" id="date" name="date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('trailer'), 'has-success': fields.trailer && fields.trailer.valid }">
    <label for="trailer" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movie.columns.trailer') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.trailer"   class="form-control" :class="{'form-control-danger': errors.has('trailer'), 'form-control-success': fields.trailer && fields.trailer.valid}" id="trailer" name="trailer" placeholder="{{ trans('admin.movie.columns.trailer') }}">
        <div v-if="errors.has('trailer')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('trailer') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movie.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.type"   class="form-control" :class="{'form-control-danger': errors.has('type'), 'form-control-success': fields.type && fields.type.valid}" id="type" name="type" placeholder="{{ trans('admin.movie.columns.type') }}">
        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('premiere'), 'has-success': fields.premiere && fields.premiere.valid }">
    <label for="premiere" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movie.columns.premiere') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.premiere" :config="datePickerConfig"  class="flatpickr" :class="{'form-control-danger': errors.has('premiere'), 'form-control-success': fields.premiere && fields.premiere.valid}" id="premiere" name="premiere" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('premiere')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('premiere') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('buy'), 'has-success': fields.buy && fields.buy.valid }">
    <label for="buy" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movie.columns.buy') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.buy"  class="form-control" :class="{'form-control-danger': errors.has('buy'), 'form-control-success': fields.buy && fields.buy.valid}" id="buy" name="buy" placeholder="{{ trans('admin.movie.columns.buy') }}">
        <div v-if="errors.has('buy')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('buy') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('active'), 'has-success': fields.active && fields.active.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="active" type="checkbox" v-model="form.active"  data-vv-name="active"  name="active_fake_element">
        <label class="form-check-label" for="active">
            {{ trans('admin.movie.columns.active') }}
        </label>
        <input type="hidden" name="active" :value="form.active">
        <div v-if="errors.has('active')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('active') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('update'), 'has-success': fields.update && fields.update.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="update" type="checkbox" v-model="form.update"  data-vv-name="update"  name="update_fake_element">
        <label class="form-check-label" for="update">
            {{ trans('update') }}
        </label>
        <input type="hidden" name="update" :value="form.update">
        <div v-if="errors.has('update')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('update') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('valid'), 'has-success': fields.valid && fields.valid.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="valid" type="checkbox" v-model="form.valid"  data-vv-name="valid"  name="valid_fake_element">
        <label class="form-check-label" for="valid">
            {{ trans('valid') }}
        </label>
        <input type="hidden" name="valid" :value="form.valid">
        <div v-if="errors.has('valid')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('valid') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('qualification_id'), 'has-success': this.fields.qualification_id && this.fields.qualification_id.valid }">
    <label for="qualification_id"
           class="col-form-label text-center col-md-4 col-lg-3">{{ trans('admin.qualification.columns.qualification') }}</label>
    <div class="col-md-8 col-lg-9">

        <multiselect
            v-model="form.qualification"
            :options="qualifications"
            :multiple="false"
            track-by="id"
            label="qualification"
            tag-placeholder="{{ __('Select qualification') }}"
            placeholder="{{ __('qualification') }}">
        </multiselect>

        <div v-if="errors.has('qualification_id')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('qualification_id') }}
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
       <span><i class="fa fa-actors"></i> {{ trans('admin.actor.columns.actor') }} </span>
    </div>

    <div class="card-block">
        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('actors'), 'has-success': this.fields.actors && this.fields.actors.valid }">
            <label for="actor_id"
                   class="col-form-label text-center col-md-4 col-lg-3">{{ trans('admin.actor.columns.actor') }}</label>
            <div class="col-md-8 col-lg-9">

                <multiselect
                        v-model="form.actors"
                        :options="actors"
                        :multiple="true"
                        track-by="id"
                        label="actor"
                        tag-placeholder="{{ __('Select actor') }}"
                        placeholder="{{ __('actor') }}">
                </multiselect>

                <div v-if="errors.has('actors')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('actors') }}
                </div>
            </div>
        </div>

    </div>
</div>


<div class="card">
    <div class="card-header">
       <span><i class="fa fa-directors"></i> {{ trans('admin.director.columns.director') }} </span>
    </div>

    <div class="card-block">
        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('directors'), 'has-success': this.fields.directors && this.fields.directors.valid }">
            <label for="director_id"
                   class="col-form-label text-center col-md-4 col-lg-3">{{ trans('admin.director.columns.director') }}</label>
            <div class="col-md-8 col-lg-9">

                <multiselect
                        v-model="form.directors"
                        :options="directors"
                        :multiple="true"
                        track-by="id"
                        label="director"
                        tag-placeholder="{{ __('Select director') }}"
                        placeholder="{{ __('director') }}">
                </multiselect>

                <div v-if="errors.has('directors')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('directors') }}
                </div>
            </div>
        </div>

    </div>
</div>
