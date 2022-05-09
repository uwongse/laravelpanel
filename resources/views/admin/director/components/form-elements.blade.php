<div class="form-group row align-items-center" :class="{'has-danger': errors.has('director'), 'has-success': fields.director && fields.director.valid }">
    <label for="director" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.director.columns.director') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.director" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('director'), 'form-control-success': fields.director && fields.director.valid}" id="director" name="director" placeholder="{{ trans('admin.director.columns.director') }}">
        <div v-if="errors.has('director')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('director') }}</div>
    </div>
</div>


