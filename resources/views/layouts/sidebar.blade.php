<!-- navbar vertical -->
<div class="app-menu">
    <div class="navbar-vertical navbar nav-dashboard">
        <div class="h-100" data-simplebar>
            <a style="padding-left:50px;" href="{{ route('dashboard') }}">
                <!--<img src="{{ asset('assets/images/dof_logo.jpg') }}" height="70" width="140" alt="Logo" />-->
		<img src="{{ asset('images/dof_logo.jpg') }}" alt="DOF Logo" height="70" width="120">

            </a>

            <!-- Menu -->
            <!-- Navbar nav -->
            <ul class="navbar-nav flex-column" id="sideNavbar">

                @auth
                @foreach (Module::getMenus() as $menu)

                    <!-- Nav item -->
                    <li class="nav-item">
                        
                        @if (!$menu->getMenus($menu->id)->isEmpty())
                            <!-- Got Child -->
                            <a
                                class="nav-link {{ !$menu->getMenus($menu->id)->isEmpty() ? ' has-arrow' : '' }} collapsed "
                                href="{{ $menu->is_parent_menu ? '#' : url(config('app.url_prefix').$menu->url) }}"
                                data-bs-toggle="collapse"
                                data-bs-target="#nav{{ Module::localize($menu->slug) }}"
                                aria-expanded="false"
                                aria-controls="nav{{ Module::localize($menu->slug) }}"
                            >
                                <i data-feather="layout" class="nav-icon me-2 icon-xxs {{ !empty($menu->icon) ? ' '.$menu->icon : '' }}"></i>
                                {{ Module::localize($menu->name) }}
                            </a>

                            <div id="nav{{ Module::localize($menu->slug) }}" class="collapse {{ request()->is(ltrim(config('app.url_prefix').explode('?', $menu->url)[0], '/')) || request()->is(ltrim(config('app.url_prefix').explode('?', $menu->url)[0], '/').'/*') ? ' show' : '' }}" data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                @foreach ($menu->getMenus($menu->id) as $childMenu)
                                    <li class="nav-item">
                                        <a class="nav-link has-arrow {{ request()->is(ltrim(config('app.url_prefix').$childMenu->url, '/')) || request()->is(ltrim(config('app.url_prefix').$childMenu->url, '/').'/*') ? ' active' : '' }}" 
                                            href="{{ url(config('app.url_prefix').$childMenu->url) }}">
                                            {{ Module::localize($childMenu->name) }}
                                        </a>
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        @else
                            <!-- No Child -->
                            <li class="nav-item">
                                <a class="nav-link has-arrow " href="{{ url(config('app.url_prefix').$menu->url) }}">
                                    <i data-feather="{{ !empty($menu->icon) ? ' '.$menu->icon : '' }}" class="nav-icon me-2 icon-xxs {{ !empty($menu->icon) ? ' '.$menu->icon : '' }}"></i>
                                    {{ Module::localize($menu->name) }}
                                </a>
                            </li>
                        @endif

                    </li>
                    <!-- Nav item -->

                @endforeach
                @endauth

            </ul>
            <!-- End Menu -->

        </div>
    </div>
</div>