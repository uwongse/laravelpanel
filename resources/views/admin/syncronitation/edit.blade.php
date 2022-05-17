@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.syncronitation.actions.edit', ['name' => $syncronitation->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <syncronitation-form
                :action="'{{ $syncronitation->resource_url }}'"
                :data="{{ $syncronitation->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.syncronitation.actions.edit', ['name' => $syncronitation->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.syncronitation.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </syncronitation-form>

        </div>
    
</div>

@endsection