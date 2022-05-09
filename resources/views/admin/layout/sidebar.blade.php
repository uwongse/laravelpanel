<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/actors') }}"><i class="nav-icon icon-plane"></i> {{ trans('admin.actor.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/cinemas') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.cinema.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/directors') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.director.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/movies') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.movie.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/projections') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.projection.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/qualifications') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.qualification.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/rooms') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.room.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/slides') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.slide.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/syncronitations') }}"><i class="nav-icon icon-plane"></i> {{ trans('admin.syncronitation.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
