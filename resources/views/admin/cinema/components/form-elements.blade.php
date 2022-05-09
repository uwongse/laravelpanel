<div class="form-group row align-items-center" :class="{'has-danger': errors.has('cinema'), 'has-success': fields.cinema && fields.cinema.valid }">
    <label for="cinema" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.cinema.columns.cinema') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.cinema" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('cinema'), 'form-control-success': fields.cinema && fields.cinema.valid}" id="cinema" name="cinema" placeholder="{{ trans('admin.cinema.columns.cinema') }}">
        <div v-if="errors.has('cinema')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('cinema') }}</div>
    </div>
</div>


