<a href="/opds/{{$row->id}}/print" title="Print" "
    class="btn px-1 text-info fs-3 ps-0">
     <i class="fa-solid fa-print"></i>
 </a>
<a href="javascript:void(0)" title="<?php echo __('messages.common.delete') ?>" data-id="{{$row->id}}"
   class="deleteOpdPatientBtn btn px-1 text-danger fs-3 ps-0">
    <i class="fa-solid fa-trash"></i>
</a>
<a href="/opds/{{$row->id}}/edit" target="_blank" title="Edit" class="editOpdPatientBtn btn px-1 text-primary fs-3 ps-0">
    <i class="fa-solid fa-pen-to-square"></i>
</a>

