<div class="dropdown">
    @if(Auth::user()->hasRole('Pharmacist|Admin'))
    <a href="#" class="myBtnPrimary" id="dropdownMenuButton" data-bs-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">{{ __('messages.common.actions') }}
        <i class="fa fa-chevron-down"></i>
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        {{-- <li>
            <a href="{{ route('medicines.create') }}"
               class="dropdown-item  px-5">{{ __('messages.medicine.new_medicine') }}</a>
        </li> --}}
        <li>
            {{-- <a href="{{ route('medicines.excel') }}" data-turbo="false"
               class="dropdown-item  px-5">{{ __('messages.common.export_to_excel') }}</a> --}}
               <a href="{{route('medicines.excel') }}" data-turbo="false"
               class="dropdown-item  px-5" target="_blank">Export All Product</a>
        </li>
    </ul>
    @else
        {{-- <a href="{{ route('medicines.create') }}"
           class="btn btn-primary">{{ __('messages.medicine.new_medicine') }}</a> --}}
    @endif
</div>
