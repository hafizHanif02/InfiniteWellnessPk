@extends('layouts.app2')
@section('title')
Patient | Nutritional Health Survey
@endsection

@section('content')

   <div class="container ">


        <h2 class="heading text-center">Nutritional Health Survey</h2>
        <br>
               <form action="{{request()->url()}}" method="POST" enctype="multipart/form-data">
                   @csrf
            <!-- <div class="d-flex justify-content-between"> -->
            <div class="row">
                <input type="hidden" name="patient_id" value="{{$patientData->id}}">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputFname">Full Name:</label>
                        <input type="text" readonly class="form-control" value="{{$patientData->user->full_name }}" name="exampleInputFname" id="exampleInputFname" aria-describedby="emailHelp"
                            placeholder=""
                             @foreach($formData as $item)
                                @if($item->fieldName == 'exampleInputFname')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach >
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="datepicker">Date of Birth</label>
                        <input type="date" readonly class="form-control" name="datepicker" value="{{$patientData->user->dob }}" id="datepicker" @foreach($formData as $item)
                                @if($item->fieldName == 'datepicker')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="datepicker2">Today's Date</label>
                        <input type="text" readonly name="datepicker2"  value="{{date('Y-m-d');}}" class="form-control" id="datepicker2"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'datepicker2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                        >
                    </div>
                </div>

            </div>




            <!-- </div> -->

            <br>

            <!-- <div class="d-flex justify-content-between"> -->
            <div class="row">

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Alcohol or
                                    wine</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck2">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck2" id="exampleCheck1"
                                   @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck2' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck2' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck3">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck3" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck3' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck3' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck4">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck4" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck4' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck4' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Artificial
                                    sweeteners</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck5">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck5" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck5' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck5' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck6">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck6" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck6' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck6' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck7">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck7" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck7' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck7' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Candy,
                                    desserts,
                                    refined sugar</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck8">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck8" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck8' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck8' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck9">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck9" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck9' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck9' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck10">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck10" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck10' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck10' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Soda
                                    drinks</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck11">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck11" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck11' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck11' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck12">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck12" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck12' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck12' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck13">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck13" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck13' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck13' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <li>
                                <label class="form-check-label" for="exampleCheck1"
                                    style="font-weight: 600;">Cigarettes</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck14">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck14" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck14' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck14' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck15">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck15" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck15' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck15' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck16">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck16" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck16' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck16' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Chewing
                                    tobacco</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck17">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck17" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck17' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck17' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck18">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck18" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck18' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck18' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck19">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck19" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck19' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck19' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1"
                                    style="font-weight: 600;">Pipes/Electronic cigarette</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck20">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck20" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck20' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck20' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck21">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck21" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck21' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck21' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck22">Everyday</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck22"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck22' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck22' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1"
                                    style="font-weight: 600;">Recreational drugs</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck23">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck23" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck23' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck23' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck24">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck24" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck24' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck24' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck25">Everyday</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck25"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck25' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck25' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Fast
                                    food</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck26">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck26" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck26' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck26' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck27">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck27" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck27' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck27' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck28">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck28" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck28' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck28' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Fried
                                    food</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck29">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck29" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck29' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck29' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck30">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck30" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck30' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck30' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck31">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck31" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck31' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck31' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1"
                                    style="font-weight: 600;">Margarine</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck32">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck32" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck32' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck32' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck33">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck33" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck33' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck33' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck34">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck34" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck34' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck34' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Milk
                                    products</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck35">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck35" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck35' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck35' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck36">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck36" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck36' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck36' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck37">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck37" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck37' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck37' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Refined
                                    flour</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck38">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck38" id="exampleCheck1"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck38' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck38' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck39">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck39" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck39' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck39' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck40">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck40" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck40' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck40' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>


                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Tap
                                    water</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck41">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck41" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck41' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck41' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck42">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck42" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck42' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck42' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck43">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck43" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck43' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck43' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Distilled
                                    water</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck44">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck44" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck44' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck44' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck45">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck45" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck45' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck45' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck46">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck46" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck46' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck46' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1"
                                    style="font-weight: 600;">Exercise</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck47" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck47' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck47' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Once or Twice a Week</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck48" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck48' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck48' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Everyday</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck49" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck49' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck49' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                        </div>
                    </div>
                </div>
            </div>




            <!-- </div> -->

            <br>
            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Do you currently follow
                            any of the following special diets or nutritional programs? (Check all that apply or skip if
                            not)</label>

                        <div class="row">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Vegetarian</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck499" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck499' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck499' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Vegan</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck50" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck50' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck50' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Paleo</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck51" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck51' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck51' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Gluten free or no wheat</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck52" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck52' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck52' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </div>


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-check">
                                        <label class="form-check-label" for="exampleCheck1">Low Fat</label>
                                        <input type="checkbox" class="form-check-input" name="exampleCheck53" id="exampleCheck1"
                                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck53' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck53' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                        >
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="exampleCheck1">Low Sodium</label>
                                        <input type="checkbox" class="form-check-input" name="exampleCheck54" id="exampleCheck1"
                                           @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck54' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck54' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                        >
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="exampleCheck1">No dairy</label>
                                        <input type="checkbox" class="form-check-input" name="exampleCheck55" id="exampleCheck1"
                                           @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck55' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck55' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                                        >
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label" for="exampleCheck1">Other:</label>
                                        <!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->

                                        <div class="d-flex justify-content-between" style=" width: 100%;">
                                            <input type="text" class="form-control " name="exampleCheck56" id="exampleInputFname"
                                                aria-describedby="emailHelp" placeholder=""
                                                   @foreach($formData as $item)
                                @if($item->fieldName == 'exampleCheck56')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                                >
                                        </div>


                                    </div>

                                </div>





                    </li>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Do you have
                            sensitivities, allergies, or reaction to certain foods?</label>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox" class="form-check-input" name="exampleCheck57" id="exampleCheck1"
                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck57' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck57' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox" class="form-check-input" name="exampleCheck58" id="exampleCheck1"
                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck58' && $item->fieldValue == '1')
                                                value="1"
                                                checked
                                                @break
                                        @elseif($item->fieldName == 'exampleCheck58' && $item->fieldValue == '0')
                                                value="0"
                                                @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                    </li>
                </div>

            </div>
            <br>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">If yes, please explain
                            which foods:</label>
                        <input type="text" class="form-control " name="exampleCheck59" id="exampleInputFname" aria-describedby="emailHelp"
                            placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'exampleCheck59')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                            >

                    </li>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Genetic predisposition: Please list medical conditions within your family’s health history</label>
                        <br>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Father</th>
                                    <th scope="col">Mother</th>
                                    <th scope="col">Siblings</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><input type="text" name="father_condition_1" class="form-control"
                                            @foreach($formData as $item)
                                @if($item->fieldName == 'father_condition_1')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="mother_condition_1" class="form-control"
                                            @foreach($formData as $item)
                                @if($item->fieldName == 'mother_condition_1')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="siblings_condition_1" class="form-control"
                                            @foreach($formData as $item)
                                @if($item->fieldName == 'siblings_condition_1')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td><input type="text" name="father_condition_2" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'father_condition_2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="mother_condition_2" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'mother_condition_2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="siblings_condition_2" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'siblings_condition_2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td><input type="text" name="father_condition_3" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'father_condition_3')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="mother_condition_3" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'mother_condition_3')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="siblings_condition_3" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'siblings_condition_3')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td><input type="text" name="father_condition_4" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'father_condition_4')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="mother_condition_4" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'mother_condition_4')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="siblings_condition_4" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'siblings_condition_4')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td><input type="text" name="father_condition_5" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'father_condition_5')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="mother_condition_5" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'mother_condition_5')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                    <td><input type="text" name="siblings_condition_5" class="form-control"
                                         @foreach($formData as $item)
                                @if($item->fieldName == 'siblings_condition_5')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                    ></td>
                                </tr>
                            </tbody>
                        </table>
                    </li>
                </div>


                </div>
            <br>

            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Current Medication/Supplements</label>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">


                        <br>
                        <br>
                        <table class="table table-bordered">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Medication/Supplement</th>
                                        <th scope="col">Dosage</th>
                                        <th scope="col">Start Date (Month/Year)</th>
                                        <th scope="col">Reason for Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($nursingData != null )
                                    @foreach ($nursingData->Medication as $key => $medication)
                                        <tr>
                                            <th scope="row">1</th>
                                        <td><input type="text" name="medication_1" class="form-control" value="{{ ($medication->medication_name === null)? '-':$medication->medication_name }}""></td>
                                        <td><input type="text" name="dosage_1" class="form-control" value="{{ ($medication->dosage === null)?'-':$medication->dosage }}"></td>
                                        <td><input type="text" name="start_date_1" class="form-control"
                                            @foreach($formData as $item)
                                 @if($item->fieldName == 'start_date_$key')
                                     value="{{trim($item->fieldValue)}}"
                                     @break
                                 @endif
                             @endforeach
                                         ></td>

                                         <td><input type="text" name="reason_1" class="form-control"
                                           @foreach($formData as $item)
                                @if($item->fieldName == 'reason_$key')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                                        ></td>
                                        </tr>
                                @endforeach
                                @endif



                                    </tbody>

                        </table>

                </div>


            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">How often do you
                            experience the following:</label>
                        <br>

                    </li>

                </div>
            </div>


            <div class="row">

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small>Possible Low Stomach HCL</small>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Bloating,
                                    burping, or
                                    discomfort after meals</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck60">None</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck60" id="exampleCheck1"
                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck60' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck60' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck61" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck61' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck61' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" name="exampleCheck62" id="exampleCheck1"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck62' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck62' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="exampleCheck63"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck63' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck63' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Feeling
                                    particularly full
                                    after eating</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck64"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck64' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck64' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck65"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck65' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck65' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck66"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck66' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck66' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck67"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck67' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck67' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1"
                                    style="font-weight: 600;">Indigestion after meals</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck68"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck68' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck68' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck69"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck69' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck69' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck70"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck70' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck70' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck71"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck71' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck71' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Tendency
                                    to have
                                    vitamin B12 deficiency</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Yes</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck72"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck72' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck72' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">No</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck73"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck73' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck73' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Burning
                                    sensation 30-40
                                    mins after eating</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck74"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck74' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck74' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck75"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck75' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck75' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck76"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck76' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck76' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck77"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck77' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck77' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>



                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Undigested
                                    food in your
                                    stool</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck78"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck78' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck78' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck79"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck79' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck79' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck80"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck80' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck80' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck81"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck81' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck81' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>



                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Food
                                    allergies or
                                    intolerances</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck82"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck82' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck82' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck83"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck83' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck83' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck84"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck84' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck84' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck85"
                                       @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck85' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck85' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>


                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Experience
                                    chronic
                                    stress</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck86"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck86' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck86' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck87"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck87' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck87' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck88"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck88' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck88' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck89"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck89' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck89' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>
                        </div>

                    </div>

                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small>Possible High Stomach HCL</small>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Burning
                                    sensation
                                    immediately after
                                    eating</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck90"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck90' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck90' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck91"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck91' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck91' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck92"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck92' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck92' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck93"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck93' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck93' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1"
                                    style="font-weight: 600;">GERD</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck94"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck94' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck94' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck95"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck95' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck95' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck96"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck96' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck96' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck97"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck97' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck97' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Heartburn
                                    is worse
                                    when lying down at
                                    night</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck98"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck98' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck98' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck99"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck99' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck99' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck100"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck100' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck100' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck101"
                                      @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck101' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck101' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>


                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Stomach
                                    ulcers</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" name="Noneone" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Noneone' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Noneone' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" name="Dailyone" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Dailyone' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Dailyone' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" name="Weeklyone" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weeklyone' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weeklyone' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" name="Monthlyone" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthlyone' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthlyone' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Vomiting
                                    or nausea</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" name="Nonetwo" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Nonetwo' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Nonetwo' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" name="Dailytwo" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Dailytwo' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Dailytwo' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" name="Weeklytwo" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weeklytwo' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weeklytwo' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" name="Monthlytwo" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthlytwo' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthlytwo' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Consume
                                    more than
                                    one caffeinated or
                                    alcoholic drink</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">None</label>
                                    <input type="checkbox" name="Nonethree" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Nonethree' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Nonethree' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                                    <input type="checkbox" name="Dailythree" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Dailythree' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Dailythree' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                    <input type="checkbox" name="Weeklythree" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weeklythree' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weeklythree' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>

                                <div class="form-check">

                                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                    <input type="checkbox" name="Monthlythree" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthlythree' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthlythree' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>


                            </li>

                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Are you
                                    smoking?</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Yes</label>
                                    <input type="checkbox" name="Yesone" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yesone' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yesone' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">No</label>
                                    <input type="checkbox" name="Noone" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Noone' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Noone' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>



                            </li>



                            <li>
                                <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Are you
                                    pregnant?</label>

                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">Yes</label>
                                    <input type="checkbox" name="Yestwo" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yestwo' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yestwo' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1">No</label>
                                    <input type="checkbox" name="Notwo" class="form-check-input" id="exampleCheck1"
                                     @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Notwo' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Notwo' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                                </div>



                            </li>




                            </div>


                            </div>
                            </div>
                            </div>

                            <!-- </div> -->

                            <br>
                            <!-- <div class="d-flex justify-content-between"> -->

                            <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                            <div class="d-flex justify-content-between" ">

                            <div>
                            <small>Possible Gut Flora
                            Imbalance</small>

                                <li>
                                    <label class=" form-check-label" for="exampleCheck1" style="font-weight: 600;">
                            Abdominal pain/
                            discomfort</label>

                            <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" name="Nonefour" class="form-check-input" id="exampleCheck1"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Nonefour' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Nonefour' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                            </div>
                            <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" name="Dailyfour" class="form-check-input" id="exampleCheck1"
                             @foreach($formData as $item)
                                @if($item->fieldName == 'Dailyfour')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                            >
                            </div>
                            <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" name="Weeklyfour" class="form-check-input" id="exampleCheck1"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weeklyfour' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weeklyfour' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                            </div>

                            <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" name="Monthlyfour" class="form-check-input" id="exampleCheck1"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthlyfour' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthlyfour' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                            </div>

                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1"
                                style="font-weight: 600;">Bloating</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None5" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily5" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly5" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly5" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Abdominal
                                dissension</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="Noneqwe" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Noneqwe' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Noneqwe' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Dailydf" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Dailydf' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Dailydf' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weeklysdvf" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weeklysdvf' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weeklysdvf' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthlysd" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthlysd' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthlysd' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1"
                                style="font-weight: 600;">Diarrhea</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None7" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily7" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly7" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly7" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1"
                                style="font-weight: 600;">Flatulence</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None8" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None8' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None8' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily8" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily8' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily8' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly8" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly8' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly8' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly8" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly8' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly8' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>



                            <li>
                            <label class="form-check-label" for="exampleCheck1"
                                style="font-weight: 600;">Weakness</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None11" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None11' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None11' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily11" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily11' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily11' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly11" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly11' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly11' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly11" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly11' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly11' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>



                            <li>
                            <label class="form-check-label" for="exampleCheck1"
                                style="font-weight: 600;">Fatigue</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None22" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None22' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None22' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily22" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily22' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily22' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly22" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly22' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly22' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly22" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly22' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly22' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>


                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Vitamin B12
                                deficiency</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None33" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None33' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None33' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily33" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily33' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily33' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly33" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly33' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly33' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly33" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly33' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly33' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Iron
                                deficiency</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None44" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None44' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None44' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily44" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily44' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily44' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly44" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly44' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly44' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly44" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly44' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly44' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Excess
                                folate</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None55" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None55' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None55' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily55" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily55' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily55' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly55" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly55' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly55' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly55" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly55' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly55' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>
                            </div>

                            </div>

                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="d-flex justify-content-between">
                            <div>
                            <small>Possible Candida</small>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Chronic
                                fatigue</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox" name="None66" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None66' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None66' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox" name="Daily66" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily66' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily66' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly66" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly66' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly66' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly66" class="form-check-input" id="exampleCheck1"
                                  @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly66' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly66' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Brain
                                fog</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox"   name="None77" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None77' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None77' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox"   name="Daily77" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily77' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily77' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox" name="Weekly77" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly77' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly77' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox" name="Monthly77" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly77' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly77' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Digestion
                                problems</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox"    name="None88"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None88' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None88' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox"    name="Daily88"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily88' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily88' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox"  name="Weekly88"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly88' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly88' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox"  name="Monthly88"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly88' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly88' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Craving sweets
                                or carbs</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox"     name="None888"    class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None888' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None888' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox"     name="Daily888"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily888' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily888' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox"   name="Weekly888"    class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly888' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly888' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox"   name="Monthly888"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly888' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly888' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Vaginal
                                itching, discharge,
                                or soreness</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox"    name="None123"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None123' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None123' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox"    name="Daily123" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily123' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily123' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox"  name="Weekly123"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly123' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly123' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox"  name="Monthly123" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly123' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly123' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>



                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Pain during
                                intercourse (Females)</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox"    name="None1234"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None1234' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None1234' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox"    name="Daily1234" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily1234' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily1234' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox"  name="Weekly1234"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly1234' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly1234' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox"  name="Monthly1234" class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly1234' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly1234' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Skin
                                disorders, such as psoriasis or skin patches</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox"     name="None124"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None124' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None124' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox"     name="Daily124"  class="form-check-input" id="exampleCheck1"
                                @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily124' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily124' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox"   name="Weekly124"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly124' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly124' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox"   name="Monthly124"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly124' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly124' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>


                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Itching of the
                                skin in
                                lower abdominal or bra
                                line</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox"      name="None126"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None126' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None126' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox"      name="Daily126"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily126' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily126' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox"    name="Weekly126"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly126' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly126' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox"    name="Monthly126"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly126' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly126' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>

                            <li>
                            <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Exposure to
                                old carpet
                                (older than 3 years) or
                                moist environment</label>

                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">None</label>
                                <input type="checkbox"    name="None127"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None127' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None127' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Daily</label>
                                <input type="checkbox"    name="Daily127"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily127' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily127' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1">Weekly</label>
                                <input type="checkbox"  name="Weekly127"   class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly127' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly127' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>

                            <div class="form-check">

                                <label class="form-check-label" for="exampleCheck1">Monthly</label>
                                <input type="checkbox"  name="Monthly127"  class="form-check-input" id="exampleCheck1"
                                 @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly127' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly127' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                >
                            </div>


                            </li>



                            </div>


                            </div>
                            </div>
                            </div>




                            <br>



                            <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                            <div class="d-flex justify-content-between" >

                            <div>
                            <small>Possible Heavy Metals
                            Exposure & Environmental
                            Chemicals</small>

                                <li>
                                    <label class=" form-check-label" for="exampleCheck1" style="font-weight: 600;">
                            Headaches</label>

                            <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" name="None788" class="form-check-input" id="exampleCheck1"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None788' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None788' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                            </div>
                            <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" name="Daily788" class="form-check-input" id="exampleCheck1"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily788' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily788' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                            </div>
                            <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" name="Weekly788" class="form-check-input" id="exampleCheck1"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly788' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly788' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                            </div>

                            <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" name="Monthly788" class="form-check-input" id="exampleCheck1"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly788' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly788' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                            </div>

                            </li>


                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Chronic joint or
                        muscle
                        pain</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" name="exampleCheck102" class="form-check-input" id="exampleCheck1"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck102' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck102' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" name="exampleCheck103" class="form-check-input" id="exampleCheck1"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck103' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck103' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" name="exampleCheck104" id="exampleCheck1"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck104' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck104' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck105"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck105' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck105' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Chronic
                        inflammation</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck106"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck106' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck106' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck107"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck107' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck107' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck108"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck108' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck108' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck109"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck109' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck109' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">An autoimmune
                        condition</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck110"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck110' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck110' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck111"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck111' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck111' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck112"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck112' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck112' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck113"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck113' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck113' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Have old dental
                        fillings or had them removed</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck114"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck114' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck114' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck115"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck115' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck115' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck116"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck116' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck116' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck117"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck117' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck117' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>



                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Live or work in an
                        industrial environment</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck118"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck118' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck118' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck119"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck119' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck119' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck120"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck120' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck120' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck121"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck121' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck121' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>



                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Do you live in a house
                        which was built before
                        1978?</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck122"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck122' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck122' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">No</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck123"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck123' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck123' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>


                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Use pesticides or
                        herbicides (bug or
                        weed killers; flea and
                        tick sprays, collars,
                        powders, or shampoos)
                        in your home or garden,
                        or on pets</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck124"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck124' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck124' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck125"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck125' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck125' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck126"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck126' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck126' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck127"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck127' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck127' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Use household air
                        fresheners, laundry
                        detergents, or other
                        cleaning products</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck128"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck128' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck128' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck129"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck129' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck129' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck130"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck130' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck130' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck131"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck131' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck131' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Are you smoking or
                        have you smoked
                        before for longer than
                        a few months?</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck132"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck132' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck132' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck133"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck133' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck133' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck134"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck134' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck134' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach>
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck135"
                         @foreach ($formData as $item)
                                        @if ($item->fieldName == 'exampleCheck135' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'exampleCheck135' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>
            </div>

        </div>

    </div>



 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="d-flex justify-content-between">
            <div>
                <small>Possible Heavy Metals
                    Exposure & Environmental
                    Chemicals</small>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Irritability or
                        anger</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example1"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example1' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example1' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example2"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example2' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example2' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example3"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example3' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example3' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example4"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example4' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example4' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Depression or mood
                        swings</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="None"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="daily"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'daily' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'daily' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Weekly"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Chronic
                        fatigue</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="none1"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'none1' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'none1' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="daily1"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'daily1' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'daily1' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="weekly1"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'weekly1' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'weekly1' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="monthly1"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'monthly1' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'monthly1' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Difficulty to
                        concentrate
                        or “brain fog”</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="none2"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'none2' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'none2' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="daily2"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'daily2' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'daily2' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="weekly2"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'weekly2' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'weekly2' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="monthly2"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'monthly2' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'monthly2' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Drink tap
                        water</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="none3"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'none3' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'none3' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="daily3"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'daily3' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'daily3' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="weekly3"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'weekly3' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'weekly3' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="monthly3"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'monthly3' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'monthly3' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Work in
                        construction</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="none4"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'none4' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'none4' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="daily4"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'daily4' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'daily4' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="weekly4"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'weekly4' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'weekly4' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="monthly4"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'monthly4' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'monthly4' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Eat fish or sea
                        food</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="none5"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'none5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'none5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="daily5"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'daily5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'daily5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="weekly5"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'weekly5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'weekly5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="monthly5"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'monthly5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'monthly5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>



<li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Use deodorants</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example5"
                                @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example5' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example5' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                                    >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example6"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example6' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example6' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >

                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"name="example7"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example7' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example7' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach>
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example8"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example8' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example8' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach>
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Cook with aluminum
                        baking plates</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example9"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example9' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example9' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example10"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example10' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example10' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example11"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example11' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example11' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example12"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example12' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example12' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">How often are you
                        near any high-powered
                        electrical wires or
                        transformers?</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example13"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example13' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example13' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example14"


                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example14' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example14' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example15"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example15' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example15' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example16"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example16' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example16' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">How often are you in
                        a place that does not
                        have proper ventilation
                        or does not have air
                        filter?</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example17"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example17' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example17' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example18"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example18' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example18' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example19"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example19' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example19' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example20"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example20' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example20' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">How often were you
                        exposed to chemicals in the past (occupational, at home, or at work)?</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example21"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example21' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example21' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example22"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example22' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example22' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example23"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example23' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example23' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example24"


                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example24' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example24' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>


                </li>



            </div>


        </div>
    </div>
    </div>



    <br>


    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

            <div class="d-flex justify-content-between">

                            <div>
                    <small>Possible Deficiency of
                        Nutrients</small>

                                <li>
                                    <label class=" form-check-label" for="exampleCheck1" style="font-weight: 600;">
                Irritability or depression</label>

                <div class="form-check">
                    <label class="form-check-label" for="exampleCheck1">None</label>
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example25"
                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example25' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example25' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                    >
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="exampleCheck1">Daily</label>
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example26"

                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example26' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example26' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                    >
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="exampleCheck1">Weekly</label>
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example27"
                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example27' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example27' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                    >
                </div>

                <div class="form-check">

                    <label class="form-check-label" for="exampleCheck1">Monthly</label>
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example28"

                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example28' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example28' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                    >
                </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Headaches</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example29"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example29' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example29' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example30"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example30' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example30' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
    >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example31"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example31' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example31' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example32"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example32' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example32' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Fatigue</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example33"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example33' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example33' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example334"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example334' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example334' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example34"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example34' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example34' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example35"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example35' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example35' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Loss of appetite and
                        weight loss</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example36"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example36' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example36' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example37"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example37' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example37' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example38"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example38' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example38' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example39"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example39' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example39' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >

                    </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Muscle
                        weakness</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input   type="checkbox" class="form-check-input" id="exampleCheck1" name="example40"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example40' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example40' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example41"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example41' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example41' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example42"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example42' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example42' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example43"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example43' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example43' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>


                </li>



                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Cracked or sore
                        lips</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example433"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example433' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example433' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example44"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example44' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example44' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example45"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example45' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example45' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example46"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example46' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example46' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>


                </li>



                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Difficulty to
                        sleep</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example47"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example47' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example47' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">No</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example48"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example48' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example48' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>


                </li>


                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Loss of
                        appetite</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example49"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example49' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example49' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example50"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example50' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example50' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input  type="checkbox" class="form-check-input" id="exampleCheck1" name="example51"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example51' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example51' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
>
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example52"


                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example52' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example52' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Impaired immune
                        function</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example53"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example53' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example53' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach



                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example54"


                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example54' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example54' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example55"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example55' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example55' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach



                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example56"

                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example56' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example56' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">A decline in your
                        mental abilities,
                        such as memory or
                        concentration</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example57"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example57' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example57' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach



                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example58"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example58' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example58' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example59"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example59' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example59' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example60"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example60' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example60' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach



                        >
                    </div>


                </li>
            </div>

        </div>

    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="d-flex justify-content-between">
            <div>
                <small>Possible Deficiency of
                    Nutrients</small>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Hair loss</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example61"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example61' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example61' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach





                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example62"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example62' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example62' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example63"


                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example63' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example63' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="example64"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example64' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example64' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">High blood
                        pressure</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example65"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example65' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example65' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example66"


                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example66' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example66' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example67"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example67' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example67' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example68"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example68' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example68' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Irregular
                        heartbeat</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example69"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example69' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example69' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example70"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example70' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example70' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example71"

                                    @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example71' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example71' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="example72"


                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'example72' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'example72' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Impotence or loss of
                        sexual function </label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="None7019"


@foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7019' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7019' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Daily7019"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7019' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7019' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Weekly7019"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'weekly7019' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'weekly7019' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7019"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7019' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7019' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach




                        >
                    </div>


                </li>

                <li>





                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Muscle spasm or
                        cramps</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7020"


@foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7020' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7020' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="Daily7020"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7020' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7020' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach





                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="Weekly7020"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7020' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7020' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach





                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="Monthly7020"


                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7020' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7020' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Tendency to feel
                        depressed</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7021"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7021' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7021' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7021"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7021' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7021' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7021"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7021' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7021' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7021"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7021' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7021' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach


                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Lower calcium levels
                        in
                        the blood</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7022"


                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7022' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7022' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7022"
                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7022' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7022' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7022"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7022' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7022' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7022"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7022' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7022' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>


                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Type 2 Diabetes or
                        prediabetic</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="checkbox"   name="Yes22770" class="form-check-input" id="exampleCheck1"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes22770' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes22770' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">No</label>
                        <input type="checkbox"    name="No22770" class="form-check-input" id="exampleCheck1"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No22770' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No22770' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>



                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Loss of bone mass:
                        Osteopenia or
                        osteoporosis</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="checkbox" name="Yes9078" class="form-check-input" id="exampleCheck1"

@foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes9078' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes9078' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">No</label>
                        <input type="checkbox" name="No9078" class="form-check-input" id="exampleCheck1"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No9078' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No9078' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>

                <li>
                    <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Sensation of numbness,
                        tingling or pins and
                        needles</label>

                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">None</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7025"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7025' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7025' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Daily</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7025"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7025' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7025' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="exampleCheck1">Weekly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7025"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7025' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7025' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>

                    <div class="form-check">

                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7025"

                        @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7025' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7025' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                        >
                    </div>


                </li>






            </div>


        </div>
    </div>
    </div>



    <br>


    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

            <div class="d-flex justify-content-between">

                <div>
                    <small>Possible Adrenal
                        Hypocortisolemia</small>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Feel tired in the
                            mornings</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7026"

                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7026' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7026' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7026"

                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7026' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7026' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7026"

                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7026' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7026' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7026"

                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7026' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7026' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Lower back
                            soreness or
                            pain</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7027"

@foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7027' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7027' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7027"

                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7027' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7027' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7027"

                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7027' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7027' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7027"

                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7027' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7027' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Back pain
                            increases
                            if you are tired or
                            standing for a long
                            period of time</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7028"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7028' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7028' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7028"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7028' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7028' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7028"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7028' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7028' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7028"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7028' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7028' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Tend to be a night
                            person</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox"  name="Yes90645" class="form-check-input" id="exampleCheck1"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes90645' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes90645' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"   name="No90645" class="form-check-input" id="exampleCheck1"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No90645' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No90645' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Feel tired or tend
                            to
                            yawn in the afternoon</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7029"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7029' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7029' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7029"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7029' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7029' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7029"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7029' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7029' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7029"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7029' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7029' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>



                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Feel dizziness
                            when
                            standing up quickly</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7030"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7030' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7030' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7030"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7030' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7030' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7030"



                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7030' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7030' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach



                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7030"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7030' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7030' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>



                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Shortness of
                            breath or
                            asthma</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox"  name="Yes906875" class="form-check-input" id="exampleCheck1"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes906875' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes906875' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"   name="No906875" class="form-check-input" id="exampleCheck1"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No906875' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No906875' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>


                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Crave salty
                            foods</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7031"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7031' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7031' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7031"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7031' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7031' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7031"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7031' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7031' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7031"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7031' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7031' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Joint pain or
                            arthritis</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7032"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7032' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7032' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7032"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7032' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7032' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7032"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7032' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7032' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7032"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7032' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7032' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Grind or clench
                            your
                            teeth at night</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7033"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7033' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7033' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7033"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7033' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7033' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7033"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7033' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7033' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7033"

                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7033' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7033' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>




                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Had or have
                            allergies</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox"  name="Yes906098" class="form-check-input" id="exampleCheck1"





                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes906098' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes906098' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach



                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"   name="No906098" class="form-check-input" id="exampleCheck1"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No906098' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No906098' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Feel anxious or
                            stressed</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7034"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7034' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7034' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7034"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7034' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7034' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7034"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7034' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7034' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7034"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7034' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7034' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Had or have a
                            stressful/
                            abusive relationship</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox" name="Yes8799715" class="form-check-input" id="exampleCheck1"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes8799715' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes8799715' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            ">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"  name="No8799715" class="form-check-input" id="exampleCheck1"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No8799715' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No8799715' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>



                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Dark circles under
                            your
                            eyes</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7035"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7035' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7035' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7035"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7035' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7035' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7035"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7035' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7035' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7035"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7035' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7035' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Puffiness under
                            your
                            eyes</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7036"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7036' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7036' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7036"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7036' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7036' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7036"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7036' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7036' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7036"



                            @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7036' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7036' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>


                    </li>



                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Sleep in and have
                            difficulty getting out of
                            bed</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7037"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7037' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7037' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7037"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7037' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7037' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7037"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7037' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7037' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7037"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7037' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7037' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>



                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Tired all the
                            time</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox" name="Yes726265" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes726265' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes726265' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"  name="No726265" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No726265' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No726265' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>


                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Work or used to
                            work
                            night shifts</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox" name="Yes989871" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes989871' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes989871' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"  name="No989871" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No989871' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No989871' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>



                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Consumed steroids
                            (e.g.
                            prednisone) for over a
                            month</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox" name="Yes9087456" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes9087456' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes9087456' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"  name="No9087456" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No9087456' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No9087456' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>



                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Symptoms reduced
                            with prescription of
                            steroids</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox" name="Yes908979" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes908979' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes908979' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"  name="No908979" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No908979' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No908979' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Pain reduced with
                            cortisol injection</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                            <input type="checkbox" name="Yes459845" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Yes459845' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Yes459845' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">No</label>
                            <input type="checkbox"  name="No459845" class="form-check-input" id="exampleCheck1"
                              @foreach ($formData as $item)
                                        @if ($item->fieldName == 'No459845' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'No458945' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                </div>

            </div>

        </div>


        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="d-flex justify-content-between">
                <div>
                    <small>Possible Low Thyroid or
                        Thyroid Hormone Imbalance</small>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Feeling cold when
                            other
                            people do not, or cold
                            fingers and toes</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7039"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7039' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7039' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7039"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7039' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7039' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7039"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7039' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7039' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7039"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7039' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7039' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Constipation or
                            less
                            than one bowel
                            movement per day</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7050"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7050' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7050' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7050"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7050' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7050' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7050"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7050' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7050' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7050"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7050' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7050' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Muscle
                            weakness</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7041"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7041' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7041' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7041"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7041' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7041' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7041"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7041' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7041' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label >
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7041"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7041' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7041' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Weight gain, even
                            though you are not
                            eating more food</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7051"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7051' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7051' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7051"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7051' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7051' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7051"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7051' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7051' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7051"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7051' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7051' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Difficulty to lose
                            weight</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7053"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7053' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7053' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7053"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7053' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7053' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7053"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7053' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7053' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7053"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7053' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7053' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Joint or muscle
                            soreness</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7054"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7054' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7054' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7054"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7054' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7054' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7054"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7054' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7054' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7054"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7054' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7054' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Feeling sad or
                            depressed</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7055"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7055' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7055' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7055"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7055' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7055' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7055"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7055' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7055' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7055"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7055' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7055' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>


                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Feeling
                            tired</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7056"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7056' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7056' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7056"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7056' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7056' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7056"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7056' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7056' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7056"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7056' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7056' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>



                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Morning headaches
                            that
                            reduce during the day</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7057"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7057' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7057' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7057"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7057' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7057' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7057"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7057' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7057' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7057"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7057' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7057' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Pale, dry
                            skin</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7058"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7058' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7058' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7058"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7058' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7058' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7058"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7058' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7058' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7058"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7058' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7058' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>




                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Dry or loss of
                            hair</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7059"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7059' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7059' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7059"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7059' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7059' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7059"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7059' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7059' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7059"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7059' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7059' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Less sweating than
                            others or usual</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7060"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7060' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7060' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7060"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7060' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7060' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7060"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7060' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7060' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7060"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7060' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7060' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Low motivation or
                            Sleep in and have “brain fog”</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7061"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7061' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7061' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7061"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7061' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7061' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7061"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7061' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7061' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7061"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7061' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7061' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Puffy face or
                            excess
                            fluids</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7062"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7062' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7062' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7062"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7022' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7022' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7062"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7062' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7062' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7062"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7062' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7062' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">A hoarse
                            voice</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7063"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7063' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7063' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7063"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7063' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7063' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7063"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7063' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7063' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7063"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7063' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7063' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>


                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Brittle
                            nails</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7064"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7064' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7064' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7064"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7064' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7064' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7064"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7064' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7064' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7064"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7064' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7064' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>



                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">More than usual
                            menstrual bleeding</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7065"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7065' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7065' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7065"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7065' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7065' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach

                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7065"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7065' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7065' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7065"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7065' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7065' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>


                    </li>

                    <li>
                        <label class="form-check-label" for="exampleCheck1" style="font-weight: 600;">Decline in memory
                            or
                            “slower thinking”</label>

                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">None</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"    name="None7066"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'None7066' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'None7066' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Daily</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"   name="Daily7066"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Daily7066' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Daily7066' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1">Weekly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="Weekly7066"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Weekly7066' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Weekly7066' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                        <div class="form-check">

                            <label class="form-check-label" for="exampleCheck1">Monthly</label>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="Monthly7066"
                             @foreach ($formData as $item)
                                        @if ($item->fieldName == 'Monthly7066' && $item->fieldValue == '1')
                                            value="1"
                                            checked
                                            @break
                                        @elseif($item->fieldName == 'Monthly7066' && $item->fieldValue == '0')
                                            value="0"
                                            @break
                                        @endif
                                    @endforeach
                            >
                        </div>

                    </li>


            </div>



            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-lx-6 col-lg-6 col-md-6 col-sm-6 col-6">
        <br>
        <label for="exampleInput8">Attach File</label>
        <input name="nutritionalFormAttachment" type="file" class="form-control " id="exampleInput8"
         @foreach($formData as $item)
                    @if($item->fieldName == 'nutritionalFormAttachment')
                        value="{{trim($item->fieldValue)}}"
                        @break
                    @endif
                @endforeach
                >
                <input type="hidden" name="oldnutritionalFormAttachment" 
                @foreach($formData as $item)
                    @if($item->fieldName == 'nutritionalFormAttachment')
                        value="{{trim($item->fieldValue)}}"
                        @break
                    @endif
                @endforeach
            >

    </div>
    <div class="col-lx-6 col-lg-6 col-md-6 col-sm-6 col-6 mt-3">
        <br>
        <label>View Attachment</label>
        <br>
        
        @foreach($formData as $item)
            @if($item->fieldName == 'nutritionalFormAttachment')
            <a href="/storage/Attachments/{{ trim($item->fieldValue) }} 
                " target="_blank">Show Attachment</a>
                @break
            @endif
        @endforeach
    </div>
    </div>



    <br>
    @role('Admin|Doctor')
    <button type="submit" class="btn btn-primary">Submit</button>
    @endrole
    </form>
    </div>



<br>
<script>
    $(function () {
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd", // Format of the date
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0" // Allow selection of years from 100 years ago to the current year
        });
    });

    $(function () {
        $("#datepicker2").datepicker({
            dateFormat: "yy-mm-dd", // Format of the date
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0" // Allow selection of years from 100 years ago to the current year
        });
    });
</script>

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

@endsection
