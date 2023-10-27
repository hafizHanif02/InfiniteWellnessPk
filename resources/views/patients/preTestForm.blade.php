@extends('layouts.app2')
@section('title')
Patient | Pre-Test Form
@endsection

@section('content')
    <div class="container">
        <br>
        <h2 class="heading text-center">Pre-Test Form</h2>
        <br>

        <form action="{{request()->url()}}" method="POST">
            @csrf


            <div class="row">
                <input type="hidden" name="patient_id" value="{{$patientData->id}}">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="exampleAccount">Mr #</label>
                    <input class="form-control" value="{{$patientData->MR }}" readonly  required id="exampleAccount" placeholder="Your Answer" type="text"
                        name="Mr"
                        @foreach ($formData as $item)
                                @if ($item->fieldName == 'Mr')
                                    value="{{ trim($item->fieldValue) }}"
                                    @break
                                @endif @endforeach>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="fullName">Full Name</label>
                    <input class="form-control" id="fullName" placeholder="Your Answer" value="{{$patientData->user->full_name }}" readonly type="text" name="Fullname"
                        @foreach ($formData as $item)
                    @if ($item->fieldName == 'Fullname')
                        value="{{ trim($item->fieldValue) }}"
                        @break
                    @endif @endforeach>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="ResponsiblePerson">Responsible Person</label>
                    <input class="form-control" id="ResponsiblePerson" placeholder="Your Answer" type="text"
                        name="ResponsiblePerson"
                        @foreach ($formData as $item)
                                @if ($item->fieldName == 'ResponsiblePerson')
                                    value="{{ trim($item->fieldValue) }}"
                                    @break
                                @endif @endforeach>
                </div>


                <div class="col-12">
                    <br>

                    <h4 class="text-left">Subjective Indicators</h4>
                </div>

                <div class="col-md-3 col-12 pb-3">
                    <label for="exampleSt">Fatigue (1-10)</label> <select name="Fatigue" class="form-control custom-select"
                        id="exampleSt">
                        <option class="text-white bg-warning">
                            @foreach ($formData as $item)
                                @if ($item->fieldName == 'Fatigue')
                                    {{ trim($item->fieldValue) }}
                                @break
                            @endif
                        @endforeach
                    </option>


                    <option value="1">
                        1
                    </option>
                    <option value="2">
                        2
                    </option>
                    <option value="3">
                        3
                    </option>
                    <option value="4">
                        4
                    </option>
                    <option value="5">
                        5
                    </option>
                    <option value="6">
                        6
                    </option>
                    <option value="7">
                        7
                    </option>
                    <option value="8">
                        8
                    </option>
                    <option value="9">
                        9
                    </option>
                    <option value="10">
                        10
                    </option>
                </select>
            </div>

            <div class="col-md-3 col-12 pb-3">
                <label for="exampleSt">Energy (1-10)</label> <select name="energy" class="form-control custom-select"
                    id="exampleSt">
                    <option class="text-white bg-warning">
                        @foreach ($formData as $item)
                            @if ($item->fieldName == 'energy')
                                {{ trim($item->fieldValue) }}
                            @break
                        @endif
                    @endforeach
                </option>
                <option value="1">
                    1
                </option>
                <option value="2">
                    2
                </option>
                <option value="3">
                    3
                </option>
                <option value="4">
                    4
                </option>
                <option value="5">
                    5
                </option>
                <option value="6">
                    6
                </option>
                <option value="7">
                    7
                </option>
                <option value="8">
                    8
                </option>
                <option value="9">
                    9
                </option>
                <option value="10">
                    10
                </option>
            </select>
        </div>

        <div class="col-md-3 col-12 pb-3">
            <label for="exampleSt">Sleep</label> <select name="sleep" class="form-control custom-select"
                id="exampleSt">
                <option class="text-white bg-warning">
                    @foreach ($formData as $item)
                        @if ($item->fieldName == 'sleep')
                            {{ trim($item->fieldValue) }}
                        @break
                    @endif
                @endforeach
            </option>
            <option value="Normal">
                Normal
            </option>
            <option value="Disturbed">
                Disturbed
            </option>
        </select>
    </div>

    <div class="col-md-3 col-12 pb-3">
        <label for="exampleSt">Hair Loss</label> <select name="hairloss" class="form-control custom-select"
            id="exampleSt">
            <option class="text-white bg-warning">
                @foreach ($formData as $item)
                    @if ($item->fieldName == 'hairloss')
                        {{ trim($item->fieldValue) }}
                    @break
                @endif
            @endforeach
        </option>
        <option value="Yes">
            Yes
        </option>
        <option value="No">
            No
        </option>
    </select>
</div>



<div class="col-md-3 col-12 pb-3">
    <label for="exampleSt">Stress (1-10)</label> <select name="stress" class="form-control custom-select"
        id="exampleSt">
        <option class="text-white bg-warning">
            @foreach ($formData as $item)
                @if ($item->fieldName == 'stress')
                    {{ trim($item->fieldValue) }}
                @break
            @endif
        @endforeach
    </option>
    <option value="1">
        1
    </option>
    <option value="2">
        2
    </option>
    <option value="3">
        3
    </option>
    <option value="4">
        4
    </option>
    <option value="5">
        5
    </option>
    <option value="6">
        6
    </option>
    <option value="7">
        7
    </option>
    <option value="8">
        8
    </option>
    <option value="9">
        9
    </option>
    <option value="10">
        10
    </option>
</select>
</div>

<div class="col-md-3 col-12 pb-3">
<label for="exampleSt">Weight Gain</label> <select name="weightgain" class="form-control custom-select"
    id="exampleSt">
    <option class="text-white bg-warning">
        @foreach ($formData as $item)
            @if ($item->fieldName == 'weightgain')
                {{ trim($item->fieldValue) }}
            @break
        @endif
    @endforeach
</option>
<option value="Yes">
    Yes
</option>
<option value="No">
    No
</option>
</select>
</div>


<div class="col-md-3 col-12 pb-3">
<label for="exampleSt">Weight Loss</label> <select name="weightloss"
class="form-control custom-select" id="exampleSt">
<option class="text-white bg-warning">
    @foreach ($formData as $item)
        @if ($item->fieldName == 'weightloss')
            {{ trim($item->fieldValue) }}
        @break
    @endif
@endforeach
</option>
<option value="Yes">
Yes
</option>
<option value="No">
No
</option>
</select>
</div>

<div class="col-md-3 col-12 pb-3">
<label for="exampleSt">Constipation</label> <select name="constipation"
class="form-control custom-select" id="exampleSt">
<option class="text-white bg-warning">
@foreach ($formData as $item)
    @if ($item->fieldName == 'constipation')
        {{ trim($item->fieldValue) }}
    @break
@endif
@endforeach
</option>
<option value="Yes">
Yes
</option>
<option value="No">
No
</option>
</select>
</div>

<div class="col-md-3 col-12 pb-3">
<label for="exampleSt">Diarrhea </label> <select name="diarrhea" class="form-control custom-select"
id="exampleSt">
<option class="text-white bg-warning">
@foreach ($formData as $item)
@if ($item->fieldName == 'diarrhea')
    {{ trim($item->fieldValue) }}
@break
@endif
@endforeach
</option>
<option value="Yes">
Yes
</option>
<option value="No">
No
</option>
</select>
</div>



<div class="col-md-3 col-12 pb-3">
<label for="exampleSt">Abdominal Pain</label> <select name="abdominalpain"
class="form-control custom-select" id="exampleSt">
<option class="text-white bg-warning">
@foreach ($formData as $item)
@if ($item->fieldName == 'abdominalpain')
{{ trim($item->fieldValue) }}
@break
@endif
@endforeach
</option>
<option value="Yes">
Yes
</option>
<option value="No">
No
</option>
</select>
</div>



<div class="col-md-3 col-12 pb-3">
<label for="exampleSt">Skin Dryness</label> <select name="skinsryness"
class="form-control custom-select" id="exampleSt">
<option class="text-white bg-warning">
@foreach ($formData as $item)
@if ($item->fieldName == 'skinsryness')
{{ trim($item->fieldValue) }}
@break
@endif
@endforeach
</option>
<option value="Yes">
Yes
</option>
<option value="No">
No
</option>
</select>
</div>




<div class="col-md-3 col-12 pb-3">
<label for="exampleSt">Brain Fog</label> <select name="brainfog" class="form-control custom-select"
id="exampleSt">
<option class="text-white bg-warning">
@foreach ($formData as $item)
@if ($item->fieldName == 'brainfog')
{{ trim($item->fieldValue) }}
@break
@endif
@endforeach
</option>
<option value="Yes">
Yes
</option>
<option value="No">
No
</option>
</select>
</div>



<div class="col-sm-6 pb-3 form-control">
    <div class="card-header form-control mt-4 mb-4">
        <h3 class="mb-0">DIGIN</h3>
    </div>
    <div class="form-control">
        <input name="Digestion" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'Digestion' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'Digestion' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Digestion</label>
    </div>
    <div class="form-control">
        <input name="IntestinalPermeability" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'IntestinalPermeability' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'IntestinalPermeability' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Intestinal Permeability</label>
    </div>
    <div class="form-control">
        <input name="GutMicrobione" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'GutMicrobione' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'GutMicrobione' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Gut Microbione</label>
    </div>
    <div class="form-control">
        <input name="ImuneSystem" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'ImuneSystem' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'ImuneSystem' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Imune System</label>
    </div>
    <div class="form-control">
        <input name="NervousSystem" type="checkbox"
            @foreach ($formData as $item)
                    @if ($item->fieldName == 'NervousSystem' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'NervousSystem' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Nervous System</label>
    </div>
</div>

<div class="col-sm-6 pb-3 form-control">
    <div class="card-header form-control mt-4 mb-4">
        <h3 class="mb-0">RISK</h3>
    </div>
    <div class="form-control">
        <input name="Hypertension" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'Hypertension' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'Hypertension' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Hypertension</label>
    </div>
    <div class="form-control">
        <input name="Diabetes" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'Diabetes' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'Diabetes' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Diabetes</label>
    </div>
    <div class="form-control">
        <input name="Depression" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'Depression' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'Depression' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Depression</label>
    </div>
    <div class="form-control">
        <input name="Anxiety" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'Anxiety' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'Anxiety' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Anxiety</label>
    </div>
    <div class="form-control">
        <input name="Alziemer" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'Alziemer' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'Alziemer' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Alziemer</label>
    </div>
    <div class="form-control">
        <input name="Chronic" type="checkbox"
            @foreach ($formData as $item)
                @if ($item->fieldName == 'Chronic' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'Chronic' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Chronic Urticaria</label>
    </div>
    <div class="form-control">
        <input name="Eczema" type="checkbox"


            @foreach ($formData as $item)


                @if ($item->fieldName == 'Eczema' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'Eczema' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach
        ><label>Eczema</label>
    </div>
</div>



@role('Admin|Doctor')
<input type="submit" class="btn btn-primary"  value="SAVE" />
@endrole
</div>






</form>
</div>

<script>
    window.addEventListener("DOMContentLoaded", function() {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');

      checkboxes.forEach(function(checkbox) {
        var hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = checkbox.name;
        checkbox.parentNode.insertBefore(hiddenInput, checkbox);

        checkbox.addEventListener("change", function() {
          if (this.checked) {
            this.value = "1";
            hiddenInput.value = "1";
            console.log(this.name + ": " + this.value);
          } else {
            this.value = "0";
            hiddenInput.value = "0";
            console.log(this.name + ": " + this.value);
          }
        });
      });
    });
    let allInput =document.getElementsByTagName("input");
for (let index = 0; index < allInput.length; index++) {
    allInput[index].value = allInput[index].value.trim();
}
</script>
<script>
        // window.close();
</script>



@endsection


