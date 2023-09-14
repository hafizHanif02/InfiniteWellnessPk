<li class="nav-item {{ Request::is('inventory/products*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.products.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Products</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/product-categories*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.product-categories.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Categories</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/dosages*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.dosages.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Dosage Forms</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/manufacturers*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.manufacturers.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Manufacturers</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/generics*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.generics.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Generic Formula</span>
    </a>
</li>
<li class="nav-item {{ Request::is('inventory/vendors*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('inventory.vendors.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Vendors</span>
    </a>
</li>
