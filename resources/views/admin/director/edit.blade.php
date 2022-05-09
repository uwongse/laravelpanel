@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.director.actions.edit', ['name' => $director->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <director-form
                :action="'{{ $director->resource_url }}'"
                :data="{{ $director->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.director.actions.edit', ['name' => $director->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.director.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </director-form>

        </div>
    
</div>

@endsection