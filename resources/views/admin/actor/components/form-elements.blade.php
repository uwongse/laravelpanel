<div class="form-group row align-items-center" :class="{'has-danger': errors.has('actor'), 'has-success': fields.actor && fields.actor.valid }">
    <label for="actor" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.actor.columns.actor') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.actor" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('actor'), 'form-control-success': fields.actor && fields.actor.valid}" id="actor" name="actor" placeholder="{{ trans('admin.actor.columns.actor') }}">
        <div v-if="errors.has('actor')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('actor') }}</div>
    </div>
</div>


