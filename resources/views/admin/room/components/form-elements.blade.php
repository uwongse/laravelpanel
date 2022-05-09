<div class="form-group row align-items-center" :class="{'has-danger': errors.has('room'), 'has-success': fields.room && fields.room.valid }">
    <label for="room" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.room.columns.room') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.room" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('room'), 'form-control-success': fields.room && fields.room.valid}" id="room" name="room" placeholder="{{ trans('admin.room.columns.room') }}">
        <div v-if="errors.has('room')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('room') }}</div>
    </div>
</div>


