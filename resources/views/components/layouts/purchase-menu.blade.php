<li class="nav-item {{ Request::is('purchase/requistion*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('purchase.requistions.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Requistion</span>
    </a>
</li>
<li class="nav-item {{ Request::is('purchase/purchaseorder*') && !Request::is('purchase/purchaseorderlist*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('purchase.purchaseorder.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Purchase Order</span>
    </a>
</li>
<li class="nav-item {{ Request::is('purchase/purchaseorderlist*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('purchase.purchaseorderlist.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Purchase Order (List)</span>
    </a>
</li>
<li class="nav-item {{ Request::is('purchase/good_receive_note*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('purchase.good_receive_note.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Good Receive Note</span>
    </a>
</li>
<li class="nav-item {{ Request::is('purchase/good-receive-statuses*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('purchase.good-receive-statuses.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Good Receive (Status)</span>
    </a>
</li>
<li class="nav-item {{ Request::is('purchase/return*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('purchase.return.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Purchase Return</span>
    </a>
</li>
<li class="nav-item {{ Request::is('purchase/purchase-return-status*') ? 'active' : '' }}">
    <a class="nav-link  d-flex align-items-center py-3"
       href="{{ route('purchase.purchase-return-status.index') }}">
        <span class="aside-menu-icon pe-3 pe-3"><i class="fas fa-calendar-check"></i></span>
        <span class="aside-menu-title">Purchase Return (Status)</span>
    </a>
</li>