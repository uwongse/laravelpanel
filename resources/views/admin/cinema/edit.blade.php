@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.cinema.actions.edit', ['name' => $cinema->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <cinema-form
                :action="'{{ $cinema->resource_url }}'"
                :data="{{ $cinema->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.cinema.actions.edit', ['name' => $cinema->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.cinema.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </cinema-form>

        </div>
    
</div>

@endsection