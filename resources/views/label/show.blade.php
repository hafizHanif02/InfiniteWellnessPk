@extends('layouts.app')
@section('title')
    {{ __('messages.bill.pos') }}
@endsection
@section('content')

        

<div class="container text-center">
    <a class="btn btn-primary mb-10" href="{{ url('lable/label-print/' .$label->pos_id.'/'.$label->medicine_id) }}">Print</a>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th class="text-end">Medicine:</th>
                <td>{{$label->name }}</td>
            </tr>
            <tr>
                <th class="text-end">Generic Formula</th> 
                <td>{{$label->brand_name }}</td>
            </tr>
            <tr>
                <th class="text-end">Quantity</th>
                <td>{{$label->quantity }}</td>

            </tr>
            <tr>
                <th class="text-end">Patient</th>
                <td>{{$label->patient_name }}</td>

            </tr>
            <tr>
                <th class="text-end">Direction Use</th>
                <td>{{$label->direction_use }}</td>

            </tr>
            <tr>
                <th class="text-end">Common Side Effect</th>
                <td>{{$label->common_side_effect }}</td>

            </tr>
            <tr>
                <th class="text-end">Date Of Sale</th>
                <td>{{$label->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>


<style>
    table{
        padding: 0px !important;
        margin: 0px !important;
    }
    table tr{
        border: 0px; 
    }

</style>

@endsection