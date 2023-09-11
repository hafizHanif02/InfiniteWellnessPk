@extends('layouts.app')
@section('title')
    {{ __('messages.patients') }}
@endsection

@section('content')

<div class="container my-3">
        <form action="{{request()->url()}}" method="POST">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Subjective Objective Assessment Plan (SOAP)</h2>
                </div>

                <br><br>
                <div class="col-12">
                    <h4 class="text-left">1. Subjective (S)</h4>
                </div>
                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <li>
                        <label for="textAreaExample1">Chief complaint</label>
                        <textarea class="form-control" id="textAreaExample1" rows="4" placeholder="Chief complaint" name="Chiefcomplaint">
                            @foreach($formData as $item)
                                @if($item->fieldName == 'Chiefcomplaint')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach
                        </textarea>

                    </li>
                </div>
                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <li>
                        <label for="textAreaExample2">History of Present Illness</label>
                        <textarea class="form-control" id="textAreaExample2" rows="4"
                            placeholder="Detailed history of present illness" name="HistoryofPresentIllness">
                            @foreach($formData as $item)
                                @if($item->fieldName == 'HistoryofPresentIllness')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                    </li>
                </div>
                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label class="form-label" for="customFile">Past Medical History</label>
                        <input type="file" class="form-control" id="customFile" name="PastMedicalHistory" value="@foreach($formData as $item)
                                @if($item->fieldName == 'PastMedicalHistory')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach"/>
                    </li>
                </div>
                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample3">Medications</label>
                        <textarea class="form-control" id="textAreaExample3" rows="4"
                            placeholder="Listing of current medications, including prescription, over-the-counter drugs, and supplements" name="Medications">
                             @foreach($formData as $item)
                             @if($item->fieldName == 'Medications')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>
                <div class="col-lx-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample4">Reofview  sysemts</label>
                        <textarea class="form-control" id="textAreaExample4" rows="4"
                            placeholder="An overview of the patient's major body systems, asking about symptoms related to each system." name="Reofviewsysemts">
                             @foreach($formData as $item)
                             @if($item->fieldName == 'Reofviewsysemts')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">2. Objective (O)</h4>
                </div>
                <div class="col-12">
                    <br>

                    <h5 class="text-left">Vital Signs</h5>
                </div>
                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <label for="exampleInput3">Blood Pressure</label>
                    <input type="text" class="form-control " id="exampleInput3" placeholder="patient blood pressure" name="BloodPressure" 
                    @foreach($formData as $item)
                                @if($item->fieldName == 'BloodPressure')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <label for="exampleInput3">Heart Rate</label>
                    <input type="text" class="form-control " id="exampleInput3" placeholder="patient heart rate" name="HeartRate" 
                    @foreach($formData as $item)
                                @if($item->fieldName == 'HeartRate')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <label for="exampleInput3">Respiratory Rate</label>
                    <input type="text" class="form-control " id="exampleInput3" placeholder="patient respiratory rate" name="RespiratoryRate" 
                     @foreach($formData as $item)
                                @if($item->fieldName == 'RespiratoryRate')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <label for="exampleInput3">Temperature</label>
                    <input type="text" class="form-control " id="exampleInput3" placeholder="patient temperature" name="Temperature" 
                     @foreach($formData as $item)
                                @if($item->fieldName == 'Temperature')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                </div>


                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <h5 class="text-left">Physical Examination</h5>

                    <textarea class="form-control" id="textAreaExample5" rows="4"
                        placeholder="Detailed examination findings, including general appearance, systems-specific examinations, and any abnormalities observed." name="PhysicalExamination">
                         @foreach($formData as $item)
                                @if($item->fieldName == 'PhysicalExamination')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach
                        </textarea>
                </div>


                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <h5 class="text-left">Laboratory and Diagnostic Tests</h5>

                    <textarea class="form-control" id="textAreaExample6" rows="4" name="LaboratoryandDiagnosticTests"
                        placeholder="Results of any tests performed, such as blood work, imaging studies, or other relevant investigations.">
                         @foreach($formData as $item)
                                @if($item->fieldName == 'LaboratoryandDiagnosticTests')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                </div>

                <div class="col-12">
                    <br>

                    <h5 class="text-left">Objective Measurements:</h5>
                </div>

                <div class="col-lx-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <br>
                    <label for="exampleInput4">Height</label>
                    <input type="text" class="form-control " id="exampleInput4" placeholder="patient height" name="Height" 
                     @foreach($formData as $item)
                                @if($item->fieldName == 'Height')
                                    value="{{trim($item->fieldValue)}}"
                                    @break
                                @endif
                            @endforeach>
                </div>

                <div class="col-lx-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <br>
                    <label for="exampleInput5">Weight</label>
                    <input type="text" class="form-control " name="Weight" id="exampleInput5" placeholder="patient weight" 
                     @foreach($formData as $item)
                                @if($item->fieldName == 'Weight')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                </div>

                <div class="col-lx-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <br>
                    <label for="exampleInput6">Body Mass Index (BMI)</label>
                    <input name="BodyMassIndex" type="text" class="form-control " id="exampleInput6" placeholder="patient BMI" 
                     @foreach($formData as $item)
                                @if($item->fieldName == 'BodyMassIndex')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                </div>

                <div class="col-lx-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <br>
                    <label for="exampleInput7">Laboratory Values</label>
                    <input name="LaboratoryValues" type="text" class="form-control " id="exampleInput7" placeholder="patient laboratory values" 
                     @foreach($formData as $item)
                                @if($item->fieldName == 'LaboratoryValues')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">3. Assessment (A)</h4>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample7">Diagnosis</label>
                        <textarea class="form-control" id="textAreaExample7" rows="4"
                            placeholder="Identification and formulation of the patient's condition or suspected medical problem." name="Diagnosis">
                              @foreach($formData as $item)
                                @if($item->fieldName == 'Diagnosis')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample8">Differential Diagnosis</label>
                        <textarea class="form-control" id="textAreaExample8" rows="4"
                            placeholder="A list of potential diagnoses that are being considered based on the patient's presentation and available information." name="DifferentialDiagnosis">
                            @foreach($formData as $item)
                                @if($item->fieldName == 'DifferentialDiagnosis')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample9">Problem List</label>
                        <textarea class="form-control" id="textAreaExample9" rows="4"
                            placeholder=" A summary of the patient's active medical issues or concerns." name="ProblemList">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'ProblemList')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample10">Prognosis</label>
                        <textarea class="form-control" id="textAreaExample10" rows="4"
                            placeholder=" An evaluation of the expected course of the condition and possible outcomes." name="Prognosis">
                              @foreach($formData as $item)
                                @if($item->fieldName == 'Prognosis')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>


                <div class="col-lx-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample11">Health Status</label>
                        <textarea class="form-control" id="textAreaExample11" rows="4"
                            placeholder="Any relevant conclusions or impressions regarding the patient's health status." name="HealthStatus">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'HealthStatus')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">4. Plan (P)</h4>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample12">Medications</label>
                        <textarea class="form-control" id="textAreaExample12" rows="4"
                            placeholder="Prescription medications, dosage, frequency, and any changes in the existing medications." name="Medications2">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'Medications2')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample13">Tests and Consultations</label>
                        <textarea class="form-control" id="textAreaExample13" rows="4"
                            placeholder="Recommendations for further diagnostic tests, referrals to specialists, or consultations." name="TestsandConsultations">
                                  @foreach($formData as $item)
                                @if($item->fieldName == 'TestsandConsultations')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample14">Patient Education</label>
                        <textarea class="form-control" id="textAreaExample14" rows="4"
                            placeholder="Information provided to the patient about their condition, treatment options, lifestyle modifications, or self-care measures." name="PatientEducation">
                              @foreach($formData as $item)
                                @if($item->fieldName == 'PatientEducation')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>


                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample15">Follow-Up</label>
                        <textarea class="form-control" id="textAreaExample15" rows="4"
                            placeholder="Instructions regarding future appointments, monitoring, or scheduled re-evaluations." name="Follow-Up">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'Follow-Up')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

                <div class="col-lx-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <br>
                    <li>
                        <label for="textAreaExample16">Other Considerations</label>
                        <textarea class="form-control" id="textAreaExample16" rows="4"
                            placeholder=" Additional recommendations, such as lifestyle changes, counseling, or preventive measures." name="OtherConsiderations">
                                   @foreach($formData as $item)
                                @if($item->fieldName == 'OtherConsiderations')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                    </li>
                </div>

            </div>
            <hr>


            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Referral Form in Family Medicine Clinic</h2>
                </div>
                <br><br>
                <div class="col-12">
                    <br>
                    <h4 class="text-left">1. Patient Information</h4>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputFname">Full Name</label>
                        <input name="FullName" type="text" class="form-control " id="exampleInputFname" aria-describedby="emailHelp"
                            placeholder=""
                                 @foreach($formData as $item)
                                @if($item->fieldName == 'FullName')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="datepicker">Date of Birth</label>
                        <input name="DateofBirth" type="text" class="form-control" id="datepicker" 
                          @foreach($formData as $item)
                                @if($item->fieldName == 'DateofBirth')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>

                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="gender">Gender</label>

                    <select class="form-select" id="gender" aria-label="Default select example" name="gendercheck">
                        <option selected>                          @foreach($formData as $item)
                                @if($item->fieldName == 'gendercheck')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach></option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Others</option>
                    </select>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputPhone">Phone Number</label>
                        <input name="PhoneNumber" type="number" class="form-control " id="exampleInputPhone" aria-describedby="emailHelp"
                            placeholder=""
                              @foreach($formData as $item)
                                @if($item->fieldName == 'PhoneNumber')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input name="Email" type="email" class="form-control " id="exampleInputEmail" aria-describedby="emailHelp"
                            placeholder=""
                               @foreach($formData as $item)
                                @if($item->fieldName == 'Email')
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-12">
                    <br>

                    <h4 class="text-left">2. Referring Physician Information</h4>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputFname2">Full Name</label>
                        <input name="FullName2" type="text" class="form-control " id="exampleInputFname2" aria-describedby="emailHelp"
                            placeholder=""
                                      @foreach($formData as $item)
                                @if($item->fieldName == 'FullName2')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputLicense">License Number</label>
                        <input name="LicenseNumber" type="number" class="form-control " id="exampleInputLicense" aria-describedby="emailHelp"
                            placeholder=""
                               @foreach($formData as $item)
                                @if($item->fieldName == 'LicenseNumber')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputPhone2">Phone Number</label>
                        <input name="PhoneNumber2" type="number" class="form-control " id="exampleInputPhone2" aria-describedby="emailHelp"
                            placeholder=""
                              @foreach($formData as $item)
                                @if($item->fieldName == 'PhoneNumber2')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail2">Email</label>
                        <input name="Email2" type="email" class="form-control " id="exampleInputEmail2" aria-describedby="emailHelp"
                            placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'Email2')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputClinic">Clinic/Hospital Name </label>
                        <input name="Clinic/HospitalName" type="text" class="form-control " id="exampleInputClinic" aria-describedby="emailHelp"
                            placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'Clinic/HospitalName')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputClinicAdd">Address</label>
                        <input name="Address2" type="text" class="form-control " id="exampleInputClinicAdd" aria-describedby="emailHelp"
                            placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'Address2')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>


                <div class="col-12">
                    <br>

                    <h4 class="text-left">3. Reason for Referral</h4>
                </div>

                <div class="col-12">
                    <textarea class="form-control" id="textAreaExample17" rows="4"
                        placeholder="Briefly describe the reason for the referral, including any specific symptoms or conditions that require specialist evaluation or intervention." name="ReasonforReferral">
                          @foreach($formData as $item)
                                @if($item->fieldName == 'ReasonforReferral')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>
                </div>

                <div class="col-12">
                    <br>

                    <h4 class="text-left">4. Medical History</h4>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputMedCon">Current Medical Conditions</label>
                        <input name="CurrentMedicalConditions" type="text" class="form-control " id="exampleInputMedCon" aria-describedby="emailHelp"
                            placeholder=""
                             @foreach($formData as $item)
                                @if($item->fieldName == 'CurrentMedicalConditions')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputPastMed">Past Medical History</label>
                        <input name="PastMedicalHistory2" type="text" class="form-control " id="exampleInputPastMed" aria-describedby="emailHelp"
                            placeholder=""
                              @foreach($formData as $item)
                                @if($item->fieldName == 'PastMedicalHistory2')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="exampleInputAllergies">Allergies</label>
                    <input name="Allergies" type="text" class="form-control " id="exampleInputAllergies" aria-describedby="emailHelp"
                        placeholder=""
                          @foreach($formData as $item)
                                @if($item->fieldName == 'Allergies')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    <!-- <textarea class="form-control" id="textAreaExample18" rows="4" placeholder=""</textarea> -->

                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="textAreaExample18">Medications</label>
                    <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                    <textarea class="form-control" id="textAreaExample18" rows="4"
                        placeholder="Medications (including dosage and frequency)" name="Medications3">
                                                  @foreach($formData as $item)
                                @if($item->fieldName == 'AllMedications3ergies')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="textAreaExample19">Surgical History </label>
                    <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                    <textarea class="form-control" id="textAreaExample19" rows="4"
                        placeholder="surgical history" name="SurgicalHistory">
                         @foreach($formData as $item)
                                @if($item->fieldName == 'SurgicalHistory')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="textAreaExample20">Family Medical History</label>
                    <small>(if relevant)</small>
                    <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                    <textarea class="form-control" id="textAreaExample20" rows="4"
                        placeholder="Family medical history " name="FamilyMedicalHistory">
                         @foreach($formData as $item)
                                @if($item->fieldName == 'FamilyMedicalHistory')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label for="textAreaExample21">Social History</label>
                    <small>(e.g., smoking, alcohol consumption)</small>
                    <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                    <textarea class="form-control" id="textAreaExample21" rows="4"
                        placeholder="(e.g., smoking, alcohol consumption) " name="SocialHistory">
                        @foreach($formData as $item)
                                @if($item->fieldName == 'SocialHistory')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>


                <div class="col-12">
                    <br>

                    <h4 class="text-left">5. Relevant Physical Examination Findings</h4>
                </div>
                <div class="col-12">
                    <small>Document any pertinent physical examination findings that support the need for a specialist
                        consultation or further investigation.</small>
                    <input name="RelevantPhysicalExaminationFindings" type="file" class="form-control" id="customFile2"
                     @foreach($formData as $item)
                                @if($item->fieldName == 'RelevantPhysicalExaminationFindings')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                </div>

                <div class="col-12">
                    <br>

                    <h4 class="text-left">6. Diagnostic Tests</h4>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="exampleInputResult">Result</label>
                    <input name="Result" type="text" class="form-control " id="exampleInputResult" aria-describedby="emailHelp"
                        placeholder=""
                             @foreach($formData as $item)
                                @if($item->fieldName == 'Result')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    <!-- <textarea class="form-control" id="textAreaExample18" rows="4" placeholder=""</textarea> -->

                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="datepicker4">Date</label>
                        <input name="Date" type="text" class="form-control" id="datepicker4"
                          @foreach($formData as $item)
                                @if($item->fieldName == 'Date')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>

                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="exampleInputHealthCare">Healthcare Facility</label>
                    <input name="HealthcareFacility" type="text" class="form-control " id="exampleInputHealthCare" aria-describedby="emailHelp"
                        placeholder=""
                                                  @foreach($formData as $item)
                                @if($item->fieldName == 'HealthcareFacility')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    <!-- <textarea class="form-control" id="textAreaExample18" rows="4" placeholder=""</textarea> -->

                </div>


                <div class="col-12">
                    <br>

                    <h4 class="text-left">7. Treatment/Management</h4>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label for="textAreaExample22">Describe Any Treatments or Management Strategies</label>
                    <small>(e.g., smoking, alcohol consumption)</small>
                    <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                    <textarea class="form-control" id="textAreaExample22" rows="4"
                        placeholder="Describe any treatments or management strategies that have been implemented prior to the referral, including medications, therapies, or lifestyle modifications." name="DescribeAnyTreatmentsorManagementStrategies">
                         @foreach($formData as $item)
                                @if($item->fieldName == 'DescribeAnyTreatmentsorManagementStrategies')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-12">
                    <br>

                    <h4 class="text-left">8. Referral Details</h4>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="gender2">Type of Specialist</label>

                    <select class="form-select" id="gender2" aria-label="Default select example" name="TypeofSpecialist"
                     @foreach($formData as $item)
                                @if($item->fieldName == 'TypeofSpecialist')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                        <option selected>Select Specialist</option>
                        <option value="1">Cardiologist</option>
                        <option value="2">Neurologist</option>
                        <option value="3">Others</option>
                    </select>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="exampleInputPreferredSpecialist">Preferred Specialist (if any)</label>
                    <input name="PreferredSpecialist" type="text" class="form-control " id="exampleInputPreferredSpecialist"
                        aria-describedby="emailHelp" placeholder=""
                        @foreach($formData as $item)
                                @if($item->fieldName == 'PreferredSpecialist')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    <!-- <textarea class="form-control" id="textAreaExample18" rows="4" placeholder=""</textarea> -->

                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="exampleInputSpecificIns">Any Specific Instructions/Concerns Related To The
                        Referral</label>
                    <input name="AnySpecificInstructions/ConcernsRelatedToTheReferral" type="text" class="form-control " id="exampleInputSpecificIns" aria-describedby="emailHelp"
                        placeholder=""
                                                @foreach($formData as $item)
                                @if($item->fieldName == 'AnySpecificInstructions/ConcernsRelatedToTheReferral')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    <!-- <textarea class="form-control" id="textAreaExample18" rows="4" placeholder=""</textarea> -->

                </div>

                <div class="col-12">
                    <br>

                    <h4 class="text-left">9. Supporting Documentation</h4>
                </div>


                <div class="col-lx-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <br>

                    <label class="form-label" for="customFile3">Attach any relevant medical records, test reports, or
                        imaging studies that support the referral.</label>
                    <input name="Attachanyrelevantmedicalrecords,testreports,orimagingstudiesthatsupportthereferral." type="file" class="form-control" id="customFile3"
                      @foreach($formData as $item)
                                @if($item->fieldName == 'Attachanyrelevantmedicalrecords,testreports,orimagingstudiesthatsupportthereferral.')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach> />

                </div>


                <div class="col-12">
                    <br>

                    <h4 class="text-left">10. Signature</h4>
                </div>



                <div class="col-lx-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <br>

                    <label class="form-label" for="customFile3">Referring physician's signature and date:
                        ________________________________</label>


                </div>

            </div>
            <hr>



            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Referral Form - Functional Medicine Clinic</h2>
                </div>
                <div class="col-12">
                    <br>
                    <h4 class="text-left">Patient Information</h4>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputPatientName">Patient Name</label>
                        <input name="PatientName" type="text" class="form-control " id="exampleInputPatientName"
                            aria-describedby="emailHelp" placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'PatientName')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="datepicker2">Date of Birth</label>
                        <input name="DateofBirth2" type="text" class="form-control" id="datepicker2"
                          @foreach($formData as $item)
                                @if($item->fieldName == 'DateofBirth2')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>

                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="gender3">Gender</label>

                    <select class="form-select" id="gender3" aria-label="Default select example" name="Gender"
                      @foreach($formData as $item)
                                @if($item->fieldName == 'Gender')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                        <option selected>Select Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Others</option>
                    </select>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputAdd3">Address</label>
                        <input name="Address3" type="text" class="form-control " id="exampleInputAdd3" aria-describedby="emailHelp"
                            placeholder=""
                              @foreach($formData as $item)
                                @if($item->fieldName == 'Address3')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputCity">City</label>
                        <input name="City" type="text" class="form-control " id="exampleInputCity" aria-describedby="emailHelp"
                            placeholder=""
                             @foreach($formData as $item)
                                @if($item->fieldName == 'City')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputState">State</label>
                        <input name="State" type="text" class="form-control " id="exampleInputState" aria-describedby="emailHelp"
                            placeholder=""
                             @foreach($formData as $item)
                                @if($item->fieldName == 'State')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputZipcode">Zip Code</label>
                        <input name="ZipCode" type="number" class="form-control " id="exampleInputZipcode" aria-describedby="emailHelp"
                            placeholder=""
                            @foreach($formData as $item)
                                @if($item->fieldName == 'ZipCode')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputPhoneNum">Phone Number</label>
                        <input name="PhoneNumber3" type="number" class="form-control " id="exampleInputPhoneNum"
                            aria-describedby="emailHelp" placeholder=""
                             @foreach($formData as $item)
                                @if($item->fieldName == 'PhoneNumber3')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="exampleInputEmailAdd">Email Address</label>
                        <input name="EmailAddress" type="email" class="form-control " id="exampleInputEmailAdd" aria-describedby="emailHelp"
                            placeholder=""
                              @foreach($formData as $item)
                                @if($item->fieldName == 'EmailAddress')
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
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
                                    {{trim($item->fieldValue)}}
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
                    <label for="textAreaExample24">Patients Medical History </small>
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="textAreaExample24" rows="4" cols="80"
                            placeholder="Briefly describe the reason for referral and any specific concerns. " name="PatientsMedicalHistory">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'PatientsMedicalHistory')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">Current Medications</h4>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label for="textAreaExample25">Patient's Current Medications</small>
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="textAreaExample25" rows="4" cols="200"
                            placeholder="List all current medications the patient is taking, including dosages. " name="CurrentMedications">
                              @foreach($formData as $item)
                                @if($item->fieldName == 'CurrentMedications')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">Allergies</h4>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label for="textAreaExample26">Are There Any Known Allergies</small>
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="textAreaExample26" rows="4" cols="200"
                            placeholder="Are there any known allergies or adverse reactions to medications, supplements, or other substances?" name="AreThereAnyKnownAllergies">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'AreThereAnyKnownAllergies')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">Laboratory and Diagnostic Tests</h4>
                </div>


                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- <label for="textAreaExample27">Are There Any Known Allergies</small> -->
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="textAreaExample27" rows="4" cols="200"
                            placeholder="Please include any recent laboratory tests, imaging reports, or other diagnostic test results related to the patient's condition" name="LaboratoryandDiagnosticTests2">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'LaboratoryandDiagnosticTests2')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">Previous Treatments</h4>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label for="textAreaExample28">Patient's Previous Treatment</small>
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="textAreaExample28" rows="4" cols="200"
                            placeholder="Has the patient received any previous treatments for their condition? If yes, please provide details" name="PatientsPreviousTreatment">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'PatientsPreviousTreatment')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>


                <div class="col-12">
                    <br>
                    <h4 class="text-left">Other Relevant Information</h4>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label for="textAreaExample29">Any Additional Information</small>
                        <!-- <input type="email" class="form-control " id="textAreaExample18" aria-describedby="emailHelp"
                            placeholder=""> -->
                        <textarea class="form-control" id="textAreaExample29" rows="4" cols="200"
                            placeholder="•	Please provide any additional information that you believe may be helpful in evaluating the patient's condition" name="AnyAdditionalInformation">
                             @foreach($formData as $item)
                                @if($item->fieldName == 'AnyAdditionalInformation')
                                    {{trim($item->fieldValue)}}
                                    @break
                                @endif
                            @endforeach</textarea>

                </div>

                <div class="col-12">
                    <br>
                    <h4 class="text-left">Signature</h4>
                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>

                    <label class="form-label" for="customFile3">Referring Provider's Signature:
                        _______________________</label>


                </div>

                <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <br>

                    <label class="form-label" for="customFile3">Date:
                        ________________________________</label>


                </div>




            </div>


<input type="submit" value="SAVE" />


        </form>

    </div>

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

    $(function () {
        $("#datepicker4").datepicker({
            dateFormat: "yy-mm-dd", // Format of the date
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0" // Allow selection of years from 100 years ago to the current year
        });
    });
</script>

@endsection

