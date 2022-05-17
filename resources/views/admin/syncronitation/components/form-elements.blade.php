<div class="form-group row align-items-center" :class="{'has-danger': errors.has('result'), 'has-success': fields.result && fields.result.valid }">
    <label for="result" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.syncronitation.columns.result') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.result" v-validate="''" id="result" name="result"></textarea>
        </div>
        <div v-if="errors.has('result')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('result') }}</div>
    </div>
</div>


