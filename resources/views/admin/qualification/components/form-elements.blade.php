<div class="form-group row align-items-center" :class="{'has-danger': errors.has('qualification'), 'has-success': fields.qualification && fields.qualification.valid }">
    <label for="qualification" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.qualification.columns.qualification') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.qualification" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('qualification'), 'form-control-success': fields.qualification && fields.qualification.valid}" id="qualification" name="qualification" placeholder="{{ trans('admin.qualification.columns.qualification') }}">
        <div v-if="errors.has('qualification')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('qualification') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('abbreviation'), 'has-success': fields.abbreviation && fields.abbreviation.valid }">
    <label for="abbreviation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.qualification.columns.abbreviation') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.abbreviation" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('abbreviation'), 'form-control-success': fields.abbreviation && fields.abbreviation.valid}" id="abbreviation" name="abbreviation" placeholder="{{ trans('admin.qualification.columns.abbreviation') }}">
        <div v-if="errors.has('abbreviation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('abbreviation') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('image'), 'has-success': fields.image && fields.image.valid }">
    <label for="image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.qualification.columns.image') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.image" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('image'), 'form-control-success': fields.image && fields.image.valid}" id="image" name="image" placeholder="{{ trans('admin.qualification.columns.image') }}">
        <div v-if="errors.has('image')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('image') }}</div>
    </div>
</div>


