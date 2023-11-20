<div class="text-center">
    @if($row->product->fixed_discount > 0)
    {{$row->product->fixed_discount}} %
    @else
    0 %
    @endif
</div>