<li class="nav-item {{ Request::is('inventory/products*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.products.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-product-hunt"></i></span>
        <span class="aside-menu-title">{{ __('messages.products') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/groups*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.groups.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">{{ __('messages.groups') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/categories*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.categories.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">{{ __('messages.categories') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/manufacturer*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.manufacturer.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">{{ __('messages.manufacturer') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/generic*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.generic.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">{{ __('messages.generic') }}</span>
    </a>
</li>
<li  class="nav-item {{ Request::is('') ? 'active' : '' }}">
    <a style="cursor: not-allowed;" class="disable nav-link  d-flex align-items-center py-3"
       href="">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">{{ __('messages.costupdates') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/supplier*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.supplier.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">{{ __('messages.supplier') }}</span>
    </a>
</li>




