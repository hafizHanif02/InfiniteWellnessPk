<a href="/dentalOpds/{{$row->id}}/print" title="Print" "
    class="btn px-1 text-info fs-3 ps-0">
     <i class="fa-solid fa-print"></i>
 </a>
 <form action="/dentalOpds/{{$row->id}}/delete" method="post" class="d-inline">
    @csrf
    <input type="hidden" name="id" value="{{$row->id}}">

    <button class="btn px-1 text-danger fs-3 ps-0" type="submit"><i class="fa-solid fa-trash"></i></button>
    {{-- <a href="/dentalOpds/{{$row->id}}/delete" title="" data-id="{{$row->id}}"
        class="btn px-1 text-danger fs-3 ps-0">
        <i class="fa-solid fa-trash"></i>
    </a> --}}
</form>

