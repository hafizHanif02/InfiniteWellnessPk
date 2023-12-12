<a href="/dentalOpds/{{$row->id}}/print" title="Print" 
    class="btn px-1 text-info fs-3 ps-0">
     <i class="fa-solid fa-print"></i>
 </a>

{{-- <a href="javascript:void(0)" title="<?php echo __('messages.common.delete') ?>" data-id="{{$row->id}}"
   class="deleteOpdPatientBtn btn px-1 text-danger fs-3 ps-0">
    <i class="fa-solid fa-trash"></i>
</a> --}}

<form action="/dentalOpds/{{$row->id}}/delete" method="post" class="d-inline">
    @csrf
    <input type="hidden" name="id" value="{{$row->id}}">

    <button class="btn px-1 text-danger fs-3 ps-0" type="submit"><i class="fa-solid fa-trash"></i></button>
    {{-- <a href="/dentalOpds/{{$row->id}}/delete" title="" data-id="{{$row->id}}"
        class="btn px-1 text-danger fs-3 ps-0">
        <i class="fa-solid fa-trash"></i>
    </a> --}}
</form>

<a href="/dentalOpds/{{$row->id}}/edit" title="Edit" class="btn px-1 text-primary fs-3 ps-0">
    <i class="fa-solid fa-pen-to-square"></i>
</a>

