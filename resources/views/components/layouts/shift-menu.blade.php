<li class="nav-item {{ Request::is('shift/transfers*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('shift.transfers.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Transfer</span>
    </a>
</li>
{{-- <li class="nav-item {{ Request::is('shift/stockout*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('shift.stock-out.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Stock Out Report</span>
    </a>
</li> --}}
