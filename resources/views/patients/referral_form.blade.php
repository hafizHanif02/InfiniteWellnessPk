@extends('layouts.app2')
@section('title')
    {{ __('messages.patients') }}
@endsection

@section('content')

{{--  {{dd($nursingData) }}  --}}
<div class="container my-3">
        <form action="{{request()->url()}}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Referral Form - Functional Medicine Clinic</h2>
                </div>
                <br><br>
                <div class="col-12">
                    <br>
                    <h4 class="text-left">1. Patient Information</h4>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputFname">Full Name</label>
                        <input name="FullName" readonly value="{{$patientData->user->full_name }}" type="text" class="form-control " id="exampleInputFname" aria-describedby="emailHelp"
                            placeholder=""
                                 @foreach($formData as $item)
                                @if($item->fieldName == 'FullName')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="mr_no">MR #</label>
                        <input name="mr_no" readonly value="{{$patientData->MR }}" type="text" class="form-control " >
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input name="age" type="text" readonly value="{{ $age }}" class="form-control" id="age"
                          @foreach($formData as $item)
                                @if($item->fieldName == 'DateofBirth')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>

                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="gender">Gender</label>
                    <input type="text" class="form-control" name="gendercheck" id="gender" readonly value="{{ ($patientData->user->gender == 0) ? 'Male' : (($patientData->user->gender == 1) ? 'Female' : 'Other') }}"
                    >
                </div>
{{-- {{dd($patientData->user->email) }} --}}
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputPhone">Phone Number</label>
                        <input name="PhoneNumber" type="text" class="form-control" readonly value="{{$patientData->user->phone}}" id="exampleInputPhone" aria-describedby="emailHelp"
                            >
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="date_of_referral">Date of Refferal</label>
                        <input name="date_of_referral" type="text" class="form-control" readonly value="{{now() }}" id="exampleInputPhone" aria-describedby="emailHelp"
                            >
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input name="Email" type="email" class="form-control" readonly value="{{$patientData->user->email}}" id="exampleInputEmail" aria-describedby="emailHelp"
                            placeholder=""
                               @foreach($formData as $item)
                                @if($item->fieldName == 'Email')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputAdd">Address</label>
                        <input name="Address" type="text" class="form-control " id="exampleInputAdd" aria-describedby="emailHelp"
                            placeholder=""
                               @foreach($formData as $item)
                                @if($item->fieldName == 'Address')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>




                <div class="col-12">
                    <br>
                    <h4 class="text-left">Referring Provider Information</h4>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputReferringName">Referring Provider Name</label>
                        <input name="ReferringProviderName" type="text" class="form-control " id="exampleInputReferringName"
                            aria-describedby="emailHelp" placeholder=""
                              @foreach($formData as $item)
                                @if($item->fieldName == 'ReferringProviderName')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputClinicName">Clinic Name</label>
                        <input name="ClinicName" type="text" class="form-control " id="exampleInputClinicName"
                            aria-describedby="emailHelp" placeholder=""
                             @foreach($formData as $item)
                                @if($item->fieldName == 'ClinicName')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputReferringAdd">Address</label>
                        <input name="Address4" type="text" class="form-control " id="exampleInputReferringAdd"
                            aria-describedby="emailHelp" placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'Address4')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputReferringCity">City</label>
                        <input name="City2" type="text" class="form-control " id="exampleInputReferringCity"
                            aria-describedby="emailHelp" placeholder=""
                              @foreach($formData as $item)
                                @if($item->fieldName == 'City2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputReferringState">State</label>
                        <input name="State2" type="text" class="form-control " id="exampleInputReferringState"
                            aria-describedby="emailHelp" placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'State2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputReferringZipcode">Zip Code</label>
                        <input name="ZipCode" type="number" class="form-control " id="exampleInputReferringZipcode"
                            aria-describedby="emailHelp" placeholder=""
                             @foreach($formData as $item)
                                @if($item->fieldName == 'ZipCode')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputReferringPhoneNum">Phone Number</label>
                        <input name="PhoneNumber4" type="number" class="form-control " id="exampleInputReferringPhoneNum"
                            aria-describedby="emailHelp" placeholder=""
                                                         @foreach($formData as $item)
                                @if($item->fieldName == 'PhoneNumber4')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputReferringEmailAdd">Email Address</label>
                        <input name="EmailAddress2" type="email" class="form-control " id="exampleInputReferringEmailAdd"
                            aria-describedby="emailHelp" placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'EmailAddress2')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">Reason for Referral</h4>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <label for="textAreaExample23">Describe The Reason For Referral / Any Specific Concerns </small>
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="textAreaExample23" rows="4" cols="80"
                            placeholder="Briefly describe the reason for referral and any specific concerns. " name="DescribeTheReasonForReferral/AnySpecificConcerns">
                              @foreach($formData as $item)
                                @if($item->fieldName == 'DescribeTheReasonForReferral/AnySpecificConcerns')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <label for="textAreaExample24">Referral Details </small>
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="textAreaExample24" rows="4" cols="80"
                            placeholder="Specify the type of specialist needed (e.g., cardiologist, neurologist, gastroenterologist). Any specific instructions or concerns related to the referral" name="PatientsMedicalHistory">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'PatientsMedicalHistory')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label for="signature"> Signature</small>
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="signature" rows="4" cols="200"
                            placeholder="Referring physician's signature and date" name="signature">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'signature')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

               
            <hr>


          

            @role('Admin|Doctor')
<input class="btn btn-primary" type="submit" value="SAVE" />
@endrole

        </form>

    </div>

<script>
          let allInput =document.getElementsByTagName("input");
for (let index = 0; index < allInput.length; index++) {
    allInput[index].value = allInput[index].value.trim();
}
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

    $(function () {
        $("#datepicker4").datepicker({
            dateFormat: "yy-mm-dd", // Format of the date
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0" // Allow selection of years from 100 years ago to the current year
        });
    });
</script>

<script>
    $(document).ready(function() {


          {{--  var apiUrl = "/patients/{{$data->id}}";  --}}

          $.ajax({
            type: "POST",
            url: apiUrl,
            success: function(response) {

              console.log("dataaaa:", response);
            },
            error: function(error) {

              console.error("Error dataaaaa:", error);
            }
          });
        });
      });



</script>


@endsection

