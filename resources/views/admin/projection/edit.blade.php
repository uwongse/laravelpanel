@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.projection.actions.edit', ['name' => $projection->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <projection-form
                :action="'{{ $projection->resource_url }}'"
                :data="{{ $projection->toJson() }}"
                :movies="{{$movies->toJson()}}"
                :rooms="{{$rooms->toJson()}}"
                :cinemas="{{$cinemas->toJson()}}"
           
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.projection.actions.edit', ['name' => $projection->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.projection.components.form-elements')

                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </projection-form>

        </div>
    
</div>

@endsection