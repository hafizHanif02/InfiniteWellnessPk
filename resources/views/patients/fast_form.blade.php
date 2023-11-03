@extends('layouts.app2')
@section('title')
    {{ __('messages.patients') }}
@endsection

@section('content')
<div style="
    justify-content: center;
    display: flex;">
        <div style="background-color: aliceblue;
    padding: 20px;
    width: 90%;
    border-radius: 29px;
    ">


            <div class="container mt-5 mb-5">

                <!-- //! FORRRMMM ONE STARTS -->
                <h1 class="text-primary">Patient Data</h1>

                <form action="{{request()->url()}}" method="POST" enctype="multipart/form-data">
@csrf
                <div class="row g-3">
                <div class="hidden">
                        <input type="text" name="formName" value="FAST FORM" readonly class="form-control" id="fastform"
                        >
                    </div>
                    <input type="hidden" name="patient_id" value="{{$patientData->id }}">
                    <div class="col-md-6">
                        <label for="mrNum" class="form-label">Mr #</label>
                        <input type="text" name="mrNum" value="{{$patientData->MR }}"  readonly class="form-control" id="mrNum"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'mrNum')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" name="fullName" readonly value="{{$patientData->user->full_name }}" class="form-control" id="fullName"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'fullName')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                    <div class="col-md-6">
                        <label for="height" class="form-label">Height</label>
                        <input type="text" name="height" value="{{($patientData!=null)?(($patientData->height!=null)?$patientData->height:''):''}}"   class="form-control" id="height"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'height')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="weight" class="form-label">Weight</label>
                        <input type="text" name="weight" value="{{($patientData!=null)?(($patientData->weight!=null)?$patientData->weight:''):''}}"  class="form-control" id="weight"
                         @foreach($formData as $item)
                                @if($item->fieldName == 'weight')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="bmi" class="form-label">Body Mass Index - BMI</label>
                        <input type="text" name="bmi" value="{{($patientData!=null)?(($patientData->bmi!=null)?$patientData->bmi:''):''}}"   class="form-control" id="bmi"
                         @foreach($formData as $item)
                                @if($item->fieldName == 'bmi')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="ibw" class="form-label">Ideal Body Weight – IBW</label>
                        <input type="text" name="ibw" value="{{($patientData!=null)?(($patientData->ibw!=null)?$patientData->ibw:''):''}}"   class="form-control" id="ibw"
                         @foreach($formData as $item)
                                @if($item->fieldName == 'ibw')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                </div>

                <!-- //! FORRRMMM ONE ENDSSSS -->


                <!-- //! FORRRMMM TWOO STARTS -->

                <div class="row g-3 mt-5">

                    <h3 class="text-uppercase"> <u> Nutritional History</u></h3>

                    <div class="col-md-6">
                        <label for="breakfast" class="form-label">Breakfast</label>
                        <input type="text" name="breakfast"  class="form-control" id="breakfast"
                                  @foreach($formData as $item)
                                @if($item->fieldName == 'breakfast')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="lunch" class="form-label">Lunch</label>
                        <input type="text" name="lunch" class="form-control" id="lunch"
                                  @foreach($formData as $item)
                                @if($item->fieldName == 'lunch')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="teaTime" class="form-label">Tea Time</label>
                        <input type="text" name="teaTime" class="form-control" id="teaTime"
                                  @foreach($formData as $item)
                                @if($item->fieldName == 'teaTime')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="dinner" class="form-label">Dinner</label>
                        <input type="text" name="dinner"  class="form-control" id="dinner"
                                  @foreach($formData as $item)
                                @if($item->fieldName == 'dinner')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>


                    <div class="col-md-6">
                        <label for="watterIntake" class="form-label">Daily Water intake </label>
                        <input type="text" name="watterIntake"  class="form-control" id="watterIntake"
                                  @foreach($formData as $item)
                                @if($item->fieldName == 'watterIntake')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <h3 class="text-uppercase mt-5"> <u> Reason for Testing </u></h3>

                    <div class="col-12">
                        <label for="reason" class="form-label">Reason for Testing </label>
                        <textarea class="form-control" id="reason" name="reason" placeholder="Reason"
                            rows="3"> @foreach($formData as $item)
                                @if($item->fieldName == 'reason')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </div>


                    <h3 class="text-uppercase mt-5"> <u> Exercise History</u></h3>


                    <div class="col-md-3">

                        <input class="form-check-input" type="checkbox" 
                            name="sedentaryLifestyle" id="sedentaryLifestyle"
                            @foreach ($formData as $item)
                @if ($item->fieldName == 'sedentaryLifestyle' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'sedentaryLifestyle' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
              @endforeach>
                        <label class="form-check-label" for="sedentaryLifestyle">
                            Sedentary lifestyle
                        </label>
                    </div>

                    <div class="col-md-3">

                        <input class="form-check-input" type="checkbox"  name="lightActivity"
                            id="lightActivity"
                            @foreach ($formData as $item)
                @if ($item->fieldName == 'lightActivity' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'lightActivity' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="lightActivity">
                            Light activity
                        </label>
                    </div>

                    <div class="col-md-3">

                        <input class="form-check-input" type="checkbox"  name="RegularExercise"
                            id="RegularExercise"
                            @foreach ($formData as $item)
                @if ($item->fieldName == 'RegularExercise' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'RegularExercise' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="RegularExercise">
                            Regular exercise
                        </label>
                    </div>

                    <div class="col-md-3">

                        <input class="form-check-input" type="checkbox"   name="yoga" id="yoga"
                        @foreach ($formData as $item)
                @if ($item->fieldName == 'yoga' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'yoga' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="yoga">
                            Yoga
                        </label>
                    </div>


                    <div class="col-md-3">

                        <input class="form-check-input" type="checkbox"   name="meditation"
                            id="meditation"
                            @foreach ($formData as $item)
                                @if ($item->fieldName == 'meditation' && $item->fieldValue == '1')
                                    value="1"
                                    checked
                                    @break
                                @elseif($item->fieldName == 'meditation' && $item->fieldValue == '0')
                                    value="0"
                                    @break
                                @endif
                            @endforeach>
                        <label class="form-check-label" for="meditation">
                            Meditation
                        </label>
                    </div>


                    <div class="col-md-6 d-flex justify-content-center align-items-center gap-3">
                        <label for="others" class="form-label">Others</label>
                        <input type="text" name="others" placeholder="others" class="form-control" id="others"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'others')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>


                    <h3 class="text-uppercase mt-5"> <u> Current Medication </u></h3>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Medication Name</th>
                                <th scope="col">Dosage</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="others2"  placeholder="Medication Name"
                                        class="form-control" id="others2"
                                        @foreach($formData as $item)
                                @if($item->fieldName == 'others2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                                </td>
                                <td>
                                    <input type="text" name="others3"  placeholder="Dosage" class="form-control"
                                        id="others3"
                                        @foreach($formData as $item)
                                @if($item->fieldName == 'others3')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                                </td>
                            </tr>


                        </tbody>
                    </table>


                    <div class="col-md-6">
                        <label for="visit1" class="form-label">1st Visit</label>
                        <input type="text" name="visit1" class="form-control" id="visit1"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'visit1')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="visit2" class="form-label">2nd Visit</label>
                        <input type="text" name="visit2"  class="form-control" id="visit2"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'visit2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="visit3" class="form-label">3rd Time</label>
                        <input type="text" name="visit3" class="form-control" id="visit3"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'visit3')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                    <div class="col-md-6">
                        <label for="visit4" class="form-label">4th Visit</label>
                        <input type="text" name="visit4"  class="form-control" id="visit4"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'visit4')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                </div>


                <!-- //! FORRRMMM TWOO ENDS -->



                <!-- //! FORRRMMM THREEE STARTS -->
                <h1 class="mt-5 text-primary">Co-Morbids</h1>



                    <h3 class="text-uppercase"> <u>Co-Morbids</u></h3>

                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox"   name="hypertension"
                            id="hypertension"
                            @foreach ($formData as $item)
                                @if ($item->fieldName == 'hypertension' && $item->fieldValue == '1')
                                    value="1"
                                    checked
                                    @break
                                @elseif($item->fieldName == 'hypertension' && $item->fieldValue == '0')
                                    value="0"
                                    @break
                                @endif
                            @endforeach>
                        <label class="form-check-label" for="hypertension">
                            Hypertension
                        </label>
                    </div>


                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox"   name="diabetesMiletus"
                            id="diabetesMiletus"
                            @foreach ($formData as $item)
                @if ($item->fieldName == 'diabetesMiletus' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'diabetesMiletus' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="diabetesMiletus">
                            Diabetes Miletus
                        </label>
                    </div>


                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox" 
                            name="ischemicHeartDisease" id="ischemicHeartDisease"
                            @foreach ($formData as $item)
                @if ($item->fieldName == 'ischemicHeartDisease' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'ischemicHeartDisease' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="ischemicHeartDisease">
                            Ischemic Heart Disease
                        </label>
                    </div>

                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox" 
                            name="depressionOrAnxiety" id="depressionOrAnxiety"
                            @foreach ($formData as $item)
                @if ($item->fieldName == 'depressionOrAnxiety' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'depressionOrAnxiety' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="depressionOrAnxiety">
                            Depression / Anxiety
                        </label>
                    </div>


                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox" 
                            name="alzheimersDisease" id="alzheimersDisease"
                            @foreach ($formData as $item)
                @if ($item->fieldName == 'alzheimersDisease' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'alzheimersDisease' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="alzheimersDisease">
                            Alzheimer’s disease
                        </label>
                    </div>


                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox"   name="chronicUrticaria"
                            id="chronicUrticaria"
                            @foreach ($formData as $item)
                @if ($item->fieldName == 'chronicUrticaria' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'chronicUrticaria' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="chronicUrticaria">
                            Chronic Urticaria
                        </label>
                    </div>


                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox"   name="eczema" id="eczema"
                        @foreach ($formData as $item)
                @if ($item->fieldName == 'eczema' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
                @elseif($item->fieldName == 'eczema' && $item->fieldValue == '0')
                    value="0"
                    @break
                @endif
            @endforeach>
                        <label class="form-check-label" for="eczema">
                            Eczema
                        </label>
                    </div>

                    <div class="col-md-3 d-flex justify-content-center align-items-center gap-3">
                        <label for="others5" class="form-label">Others</label>
                        <input type="text" name="others5"  placeholder="others" class="form-control" id="others5"
                        @foreach($formData as $item)
                                @if($item->fieldName == 'others5')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

            </div>


            <div class="container rounded">

            <h1 class="mt-5 text-primary mb-5">Consultation</h1>


                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col" colspan="1"></th>
                            <th scope="col" colspan="1">Base Line</th>
                            <th scope="col" colspan="1">After 1 Month</th>
                            <th scope="col" colspan="1">After 2 Month</th>
                            <th scope="col" colspan="2">After 4 Month</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- //! First table starts -->

                        <tr>
                            <td colspan="3">
                                <h5 style="text-decoration: underline;">Subjective Indicators</h5>

                            </td>
                            <td>

                            </td>
                            <td>
                            </td>
                            <td>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <p>Energy</p>
                            </td>

                            <td>
                                <select id="Energy1" name="Energy1" class=" form-select "
                                    aria-label="Default select example" >
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Energy1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                            <td>
                                <select id="Energy2" name="Energy2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Energy2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>

                            <td>
                                <select id="Energy3" name="Energy3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Energy3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="Energy4" name="Energy4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Energy4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Fatigue</p>
                            </td>

                            <td>
                                <select id="Fatigue1" name="Fatigue1" class=" form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Fatigue1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                            <td>
                                <select id="Fatigue2" name="Fatigue2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Fatigue2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>

                            <td>
                                <select id="Fatigue3" name="Fatigue3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Fatigue3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="Fatigue4" name="Fatigue4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Fatigue4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Sleep</p>
                            </td>

                            <td>
                                <select id="Sleep1" name="Sleep1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Sleep1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Normal">Normal</option>
                                    <option value="Distrub">Distrub</option>
                                </select>
                            </td>
                            <td>
                            <select id="Sleep2" name="Sleep2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Sleep2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Normal">Normal</option>
                                    <option value="Distrub">Distrub</option>
                                </select>
                            </td>

                            <td>
                            <select id="Sleep3" name="Sleep3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Sleep3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Normal">Normal</option>
                                    <option value="Distrub">Distrub</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="Sleep4" name="Sleep4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Sleep4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Normal">Normal</option>
                                    <option value="Distrub">Distrub</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Hair Loss</p>
                            </td>

                            <td>
                                <select id="HairLoss1" name="HairLoss1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'HairLoss1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td>
                                <select id="HairLoss2" name="HairLoss2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'HairLoss2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>

                            <td>
                                <select id="HairLoss3" name="HairLoss3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'HairLoss3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="HairLoss4" name="HairLoss4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'HairLoss4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Stress</p>
                            </td>

                            <td>
                                <select id="Stress1" name="Stress1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Stress1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td>
                                <select id="Stress2" name="Stress2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Stress2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>

                            <td>
                                <select id="Stress3" name="Stress3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Stress3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="Stress4" name="Stress4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Stress4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Brain Fog/ Concentration</p>
                            </td>

                            <td>
                                <select id="Concentration1" name="Concentration1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Concentration1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td>
                                <select id="Concentration2" name="Concentration2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Concentration2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>

                            <td>
                                <select id="Concentration3" name="Concentration3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Concentration3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="Concentration4" name="Concentration4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Concentration4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Change in Weight</p>
                            </td>

                            <td>
                                <select id="ChangeinWeight1" name="ChangeinWeight1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'ChangeinWeight1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Gain">Gain</option>
                                    <option value="Loss">Loss</option>
                                    <option value="No Change">No Change</option>
                                </select>
                            </td>
                            <td>
                                <select id="ChangeinWeight2" name="ChangeinWeight2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'ChangeinWeight2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Gain">Gain</option>
                                    <option value="Loss">Loss</option>
                                    <option value="No Change">No Change</option>
                                </select>
                            </td>

                            <td>
                                <select id="ChangeinWeight3" name="ChangeinWeight3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'ChangeinWeight3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Gain">Gain</option>
                                    <option value="Loss">Loss</option>
                                    <option value="No Change">No Change</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="ChangeinWeight4" name="ChangeinWeight4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'ChangeinWeight4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Gain">Gain</option>
                                    <option value="Loss">Loss</option>
                                    <option value="No Change">No Change</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Skin Changes</p>
                            </td>

                            <td>
                                <select id="SkinChanges1" name="SkinChanges1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'SkinChanges1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Dryness ">Dryness</option>
                                    <option value="Itching ">Itching</option>
                                    <option value="Rash ">Rash</option>
                                    <option value="Nothing ">Nothing</option>
                                </select>
                            </td>
                            <td>
                                <select id="SkinChanges2" name="SkinChanges2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'SkinChanges2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Dryness">Dryness</option>
                                    <option value="Itching">Itching</option>
                                    <option value="Rash">Rash</option>
                                    <option value="Nothing">Nothing</option>
                                </select>
                            </td>

                            <td>
                                <select id="SkinChanges3" name="SkinChanges3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'SkinChanges3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Dryness">Dryness</option>
                                    <option value="Itching">Itching</option>
                                    <option value="Rash">Rash</option>
                                    <option value="Nothing">Nothing</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="SkinChanges4 " name="SkinChanges4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'SkinChanges4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Dryness">Dryness</option>
                                    <option value="Itching">Itching</option>
                                    <option value="Rash">Rash</option>
                                    <option value="Nothing">Nothing</option>
                                </select>
                            </td>
                        </tr>






                        <!-- //! First second starts -->

                        <tr>
                            <td colspan="3 ">
                                <h5 style="text-decoration: underline; ">Abdominal Symptoms</h5>

                            </td>
                            <td>

                            </td>
                            <td>
                            </td>
                            <td>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <p>Diarrhea</p>
                            </td>

                            <td>
                                <select id="Diarrhea1" name="Diarrhea1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Diarrhea1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                            <td>
                                <select id="Diarrhea2" name="Diarrhea2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Diarrhea2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>

                            <td>
                                <select id="Diarrhea3" name="Diarrhea3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Diarrhea3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="Diarrhea4" name="Diarrhea4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Diarrhea4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Constipation</p>
                            </td>

                            <td>
                                <select id="Constipation1" name="Constipation1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Constipation1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                            <td>
                                <select id="Constipation2" name="Constipation2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Constipation2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>

                            <td>
                                <select id="Constipation3" name="Constipation3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Constipation3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="Constipation4" name="Constipation4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'AbdominalPain2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Abdominal Pain</p>
                            </td>

                            <td>
                                <select id="AbdominalPain1" name="AbdominalPain1" class="form-select "
                                    aria-label="Default select example ">
                                     <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'AbdominalPain1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                            <td>
                                <select id="AbdominalPain2" name=" " class="form-select "
                                    aria-label="Default select example ">
                                     <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'AbdominalPain2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>

                            <td>
                                <select id="AbdominalPain3" name="AbdominalPain3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'AbdominalPain3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="AbdominalPain4" name="AbdominalPain4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'AbdominalPain4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <p>Bloating</p>
                            </td>

                            <td>
                                <select id="Bloating1" name="Bloating1" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Bloating1')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>

                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                            <td>
                                <select id="Bloating2" name="Bloating2" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Bloating2')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>

                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>

                            <td>
                                <select id="Bloating3" name="Bloating3" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Bloating3')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>

                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                            <td colspan="3 ">
                                <select id="Bloating4" name="Bloating4" class="form-select "
                                    aria-label="Default select example ">
                                    <option
                                    @foreach($formData as $item)
                                        @if($item->fieldName == 'Bloating4')
                                            value="{{trim($item->fieldValue)}}" selected>{{trim($item->fieldValue)}}
                                            @break
                                        @endif
                                    @endforeach
                                    </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Sometimes">Sometimes</option>
                                </select>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <div class="row">

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-6 col-6">
                    <br>
                    <label for="exampleInput8">Attach File</label>
                    <input name="fastFormAttachment" type="file" class="form-control " id="exampleInput8"
                     @foreach($formData as $item)
                                @if($item->fieldName == 'fastFormAttachment')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach
                            >
                            <input type="hidden" name="oldfastFormAttachment" 
                            @foreach($formData as $item)
                                @if($item->fieldName == 'fastFormAttachment')
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
                        @if($item->fieldName == 'fastFormAttachment')
                        <a href="/storage/Attachments/{{ trim($item->fieldValue) }} 
                            " target="_blank">Show Attachment</a>
                            @break
                        @endif
                    @endforeach
                </div>
            </div>


        </div>
        @role('Admin|Doctor')
        <button type="submit" class="btn btn-primary mt-5">Submit</button>
        @endrole
    </form>
        </div>
    </div>
    <script>
            let allInput =document.getElementsByTagName("input");
for (let index = 0; index < allInput.length; index++) {
    allInput[index].value = allInput[index].value.trim();
}

let allInput2 =document.getElementsByTagName("textarea");
for (let index = 0; index < allInput2.length; index++) {
    allInput2[index].value = allInput2[index].value.trim();
}
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


      // Add event listeners to the height and weight input fields
const heightInput = document.getElementById("height");
const weightInput = document.getElementById("weight");
const bmiInput = document.getElementById("bmi");
const ibwInput = document.getElementById("ibw");

heightInput.addEventListener("input", calculateBMI);
weightInput.addEventListener("input", calculateBMI);
heightInput.addEventListener("input", calculateIBW);
weightInput.addEventListener("input", calculateIBW);

// Function to calculate BMI
function calculateBMI() {
    const weightKg = parseFloat(weightInput.value);
    const heightCm = parseFloat(heightInput.value);

    // Convert height to meters (1 meter = 100 cm)
    const heightM = heightCm / 100;

    // Calculate BMI
    const bmi = (weightKg / (heightM * heightM)).toFixed(2);

    // Update the BMI input field
    bmiInput.value = isNaN(bmi) ? "" : bmi;

    // Determine BMI category based on the calculated BMI
    let bmiCategory = "";

    if (bmi < 18.5) {
        bmiCategory = "Underweight";
    } else if (bmi >= 18.5 && bmi < 23) {
        bmiCategory = "Normal";
    } else if (bmi >= 23 && bmi < 27) {
        bmiCategory = "Overweight";
    } else if (bmi >= 27) {
        bmiCategory = "Obese";
    }

    // Add the BMI category to the BMI input field
    if (bmiCategory) {
        bmiInput.value += " (" + bmiCategory + ")";
    }
}

// Function to calculate IBW
function calculateIBW() {
    // Get height in centimeters
    const heightCm = parseFloat(heightInput.value);
    const gender = "male"; // Static variable to specify gender ("male" or "female")

    // Calculate IBW based on gender
    let ibw;

    if (gender === "male") {
        ibw = 50 + 2.3 * ((heightCm - 152.4) / 2.54); // Convert height from cm to inches
    } else if (gender === "female") {
        ibw = 45.5 + 2.3 * ((heightCm - 152.4) / 2.54); // Convert height from cm to inches
    } else {
        ibw = NaN; // Invalid gender
    }

    // Update the IBW input field with the calculated value
    ibwInput.value = isNaN(ibw) ? "" : ibw.toFixed(2); // Display IBW with two decimal places
}

// Initial calculations when the page loads
calculateBMI();
calculateIBW();

    </script>
    @endsection
