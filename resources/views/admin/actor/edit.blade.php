@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.actor.actions.edit', ['name' => $actor->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <actor-form
                :action="'{{ $actor->resource_url }}'"
                :data="{{ $actor->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.actor.actions.edit', ['name' => $actor->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.actor.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </actor-form>

        </div>
    
</div>

@endsection