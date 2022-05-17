<div class="form-group row align-items-center" :class="{'has-danger': errors.has('hour'), 'has-success': fields.hour && fields.hour.valid }">
    <label for="hour" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.projection.columns.hour') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.hour" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('hour'), 'form-control-success': fields.hour && fields.hour.valid}" id="hour" name="hour" placeholder="{{ trans('admin.projection.columns.hour') }}">
        <div v-if="errors.has('hour')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('hour') }}</div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('release_date'), 'has-success': fields.release_date && fields.release_date.valid }">
    <label for="release_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.projection.columns.release_date') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.release_date"  class="form-control" :class="{'form-control-danger': errors.has('release_date'), 'form-control-success': fields.release_date && fields.release_date.valid}" id="release_date" name="release_date" placeholder="{{ trans('admin.projection.columns.release_date') }}">
        <div v-if="errors.has('release_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('release_date') }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fa fa-user"></i> movie </span>
    </div>

    <div class="card-block">
        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('movie_id'), 'has-success': this.fields.movie_id && this.fields.movie_id.valid }">
            <label for="movie_id"
                   class="col-form-label text-center col-md-4 col-lg-3">{{ trans('admin.projection.columns.movie_id') }}</label>
            <div class="col-md-8 col-lg-9">

                <multiselect
                        v-model="form.movie"
                        :options="movies"
                        :multiple="false"
                        track-by="id"
                        label="title"
                        tag-placeholder="{{ __('Select movie') }}"
                        placeholder="{{ __('movie') }}">
                </multiselect>

                <div v-if="errors.has('movie_id')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('movie_id') }}
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fa fa-user"></i> room </span>
    </div>

    <div class="card-block">
        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('room_id'), 'has-success': this.fields.room_id && this.fields.room_id.valid }">
            <label for="room_id"
                   class="col-form-label text-center col-md-4 col-lg-3">{{ trans('admin.projection.columns.room_id') }}</label>
            <div class="col-md-8 col-lg-9">

                <multiselect
                        v-model="form.room"
                        :options="rooms"
                        :multiple="false"
                        track-by="id"
                        label="room"
                        tag-placeholder="{{ __('Select room') }}"
                        placeholder="{{ __('room') }}">
                </multiselect>

                <div v-if="errors.has('room_id')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('room_id') }}
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fa fa-user"></i> cinema </span>
    </div>

    <div class="card-block">
        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('cinema_id'), 'has-success': this.fields.cinema_id && this.fields.cinema_id.valid }">
            <label for="cinema_id"
                   class="col-form-label text-center col-md-4 col-lg-3">{{ trans('admin.projection.columns.cinema_id') }}</label>
            <div class="col-md-8 col-lg-9">

                <multiselect
                        v-model="form.cinema"
                        :options="cinemas"
                        :multiple="false"
                        track-by="id"
                        label="cinema"
                        tag-placeholder="{{ __('Select cinema') }}"
                        placeholder="{{ __('cinema') }}">
                </multiselect>

                <div v-if="errors.has('cinema_id')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('cinema_id') }}
                </div>
            </div>
        </div>

    </div>
</div>

