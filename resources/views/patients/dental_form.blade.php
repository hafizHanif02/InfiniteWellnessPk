@extends('layouts.app2')
@section('title')
    {{ __('messages.patients') }}
@endsection

@section('content')

<style>
    *{
        padding: 0;
        margin: 0;
    }
.underline {
    border: none;
    border-bottom: 2px solid #000; 
    width: 80%;
}
.dd{
    margin-left: 20px;
}
.bordBox {
    border: 1px solid black;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: -12px;
    padding-bottom: -12px;
    width: 10px;
    height: 10px;
    
  
}
 .names{
    border: 1px solid black;
    padding: 10px;
    width: 10px;
    height: 10px; 
}
.card{
    border: 2px solid;
    margin: 10px;
    padding: 10px 20px;
}
.space{
margin-left: -10px;    
}
.female{
    text-align: center;
}
.check_box1{
  width: 25px;
  border: 1px solid #000;
    
}
.in1{
    border-top: none;
    border-left: none;
    border-right: none;
    width: 100%;
}
.text_start{
    padding: 30px;
}
.patientDetails{
    padding: 30px;  
}



  </style>  

<div class="container my-3">
    <center>
        <div style="margin-top: 25px !important; margin-bottom: 25px !important">
            <img src="https://app.infinitewellnesspk.com/logo.png" width="120px" alt="logo">
        </div>
    </center>
    <form action="{{request()->url()}}" method="POST" enctype="multipart/form-data">
        @csrf
    <!-- Site title -->
<div class="mainForm">
    <input type="hidden" name="patient_id" value="{{$patientData->id}}">
<div class="container text-center">
    <h3 class="siteTitle">INFINITE WELLNESS PK</h3>
    <span class="sitePara underline">Plot No.35/135, CP & Berar Cooperating Housing Society, PECHS Block Block 7/8 Karachi East</span>
</div>

<!-- patient details -->
<div class="text_start">
<div class="patientDetails card mt-3 ">
    <div class="row ">
        <div class="d-flex col-md-6 mt-2">
            <label class="date form-label">Date:</label>
            @foreach ($formData as $item)
                @if ($item->fieldName == 'dates')
                    @php
                        $dateValue = date('Y-m-d', strtotime(trim($item->fieldValue)));
                    @endphp
                    <input type="date" name="dates" style="margin-left: 35px;" id="dates" value="{{ $dateValue }}">
                    @break
                @endif
            @endforeach
        </div>
        <div class="col-md-2 mt-3 ">
            <label class=" form-label in1 mt-3" style="margin-left: -55px;">Dentist Name:</label>    
        </div>
        <div class="col-md-4"> <input  type="text" name="dentist_name" value="@foreach($formData as $item)
            @if($item->fieldName == 'dentist_name')
                {{trim($item->fieldValue)}}
                @break
            @endif
        @endforeach" class="in1 mt-3" ></div>
    </div>

    <div class="row" >
        <div class="col-md-1">
            <label class="age mt-3 form-label"> Name:</label>
        </div>
        <div class="d-flex col-md-auto" id="nameinp" style="margin-left: -55px;">
     <input type="text" style="margin-left: 42px;  width: 600px;" class="mt-3 mr-16" name="name" readonly value="{{$patientData->user->full_name }}">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-auto">
            <label class="gender mt-2 form-label"> Age:</label> 
        </div>
        <div class="d-flex col-md-1 mt-2">
         <input type="number" style="margin-left: 15px;" readonly name="age" placeholder="{{$age }}" value="{{$patientData->user->dob }}">   
        </div> 


        <div class="col-md-auto">
            <label class="gender mt-2 form-label" style="margin-left: 125px;"> Gender:</label>
        </div>
        <div class="d-flex col-md-auto">
            <input type="checkbox" class="check_box1" name="male" @foreach ($formData as $item)
            @if ($item->fieldName == 'male' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
            @elseif($item->fieldName == 'male' && $item->fieldValue == '0')
                    value="0"
                    @break
            @endif
        @endforeach >   
        </div> 
        <div class="col-md-auto">
            <label class="male mt-2 form-label" style="margin-left: -15px;"> Male:</label>
        </div>
        <div class="d-flex col-md-auto">
            <input type="checkbox" class="check_box1" name="female" @foreach ($formData as $item)
            @if ($item->fieldName == 'female' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
            @elseif($item->fieldName == 'female' && $item->fieldValue == '0')
                    value="0"
                    @break
            @endif
        @endforeach >    
        </div>
        <div class="col-md-auto ml-auto " style="margin-left: -15px; ">
            <label class="female mt-2 form-label" > Female:</label>
        </div>
        <div class="col-md-auto">
            <label class="mrno mt-2 form-label "> MR No:</label>
        </div>    
        <div class="d-flex col-md-4 mt-2">
        <input type="text" name="mr_no" readonly value="{{$patientData->MR }}">
        </div>    
    </div>
</div>
</div>
<div class="text_start "> 
    <div class="PresentComplaint">
    <h3 class="">Presenting Complaints:</h3>
    <div class="row">
       
        <div class="d-flex col-md-auto"> 
             <input type="checkbox" class="check_box1" name="Pain" @foreach ($formData as $item)
             @if ($item->fieldName == 'Pain' && $item->fieldValue == '1')
                     value="1"
                     checked
                     @break
             @elseif($item->fieldName == 'Pain' && $item->fieldValue == '0')
                     value="0"
                     @break
             @endif
         @endforeach >
        </div> 
         <div class="col-md-2">
            <label class="gender form-label mt-4"> Pain</label> 
        </div>
        <div class="d-flex col-md-auto">
            <input type="checkbox" class="check_box1" name="Swelling" @foreach ($formData as $item)
            @if ($item->fieldName == 'Swelling' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
            @elseif($item->fieldName == 'Swelling' && $item->fieldValue == '0')
                    value="0"
                    @break
            @endif
        @endforeach >      
        </div> 
         <div class="col-md-2">
            <label class="gender form-label mt-4"> Swelling</label> 
        </div>
        <div class="d-flex col-md-auto">
            <input type="checkbox" class="check_box1" name="Malocclusion" @foreach ($formData as $item)
            @if ($item->fieldName == 'Malocclusion' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
            @elseif($item->fieldName == 'Malocclusion' && $item->fieldValue == '0')
                    value="0"
                    @break
            @endif
        @endforeach >       
        </div> 
         <div class="col-md-2">
            <label class="gender form-label mt-4"> Malocclusion</label> 
        </div>
        <div class="d-flex col-md-auto">
            <input type="checkbox" class="check_box1" name="missingTeeth"  @foreach ($formData as $item)
            @if ($item->fieldName == 'missingTeeth' && $item->fieldValue == '1')
                    value="1"
                    checked
                    @break
            @elseif($item->fieldName == 'missingTeeth' && $item->fieldValue == '0')
                    value="0"
                    @break
            @endif
        @endforeach >       
        </div> 
         <div class="col-md-2">
            <label class="gender form-label mt-2"> Replace missing Teeth</label> 
        </div>    
 </div> 

 <div class="row">
       
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="Mobility"  @foreach ($formData as $item)
        @if ($item->fieldName == 'Mobility' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Mobility' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >    
    </div> 
     <div class="col-md-2">
        <label class="gender mt-4 form-label"> Mobility</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="FoodImpaction"  @foreach ($formData as $item)
        @if ($item->fieldName == 'FoodImpaction' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'FoodImpaction' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >       
    </div> 
     <div class="col-md-2">
        <label class="gender mt-4 form-label"> Food Impaction</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="Aesthetics"  @foreach ($formData as $item)
        @if ($item->fieldName == 'Aesthetics' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Aesthetics' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >       
    </div>        
     <div class="col-md-2">
        <label class="gender mt-4 form-label"> Aesthetics</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="LimitedMouthOpening"  @foreach ($formData as $item)
        @if ($item->fieldName == 'LimitedMouthOpening' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'LimitedMouthOpening' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >      
    </div> 
     <div class="col-md-3">
        <label class="gender mt-4 form-label"> Limited Mouth Opening</label> 
    </div>    
</div> 

<div class="row">
       
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="BleedingGums"  @foreach ($formData as $item)
        @if ($item->fieldName == 'BleedingGums' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'BleedingGums' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >          
    </div> 
     <div class="col-md-2 ">
        <label class="gender mt-4 form-label"> Bleeding Gums</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="Sensitivity"  @foreach ($formData as $item)
        @if ($item->fieldName == 'Sensitivity' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Sensitivity' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >  
    </div> 
     <div class="col-md-2 ">
        <label class="gender mt-4 form-label"> Sensitivity</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="Fracture" @foreach ($formData as $item)
        @if ($item->fieldName == 'Fracture' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Fracture' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >       
    </div> 
     <div class="col-md-2 ">
        <label class="gender mt-4 form-label"> Fracture</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="Prostheris" @foreach ($formData as $item)
        @if ($item->fieldName == 'Prostheris' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Prostheris' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >        
    </div> 
     <div class="col-md-2">
        <label class="gender mt-4 form-label"> Prostheris</label> 
    </div>    
</div> 

<div class="row mt-3">
       
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="Caries" @foreach ($formData as $item)
        @if ($item->fieldName == 'Caries' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Caries' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >       
    </div> 
     <div class="col-md-2">
        <label class="gender mt-2 form-label"> Caries</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="Staining"  @foreach ($formData as $item)
        @if ($item->fieldName == 'Staining' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Staining' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >         
    </div> 
     <div class="col-md-2 mt-2 ">
        <label class="gender form-label"> Staining</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input type="checkbox" class="check_box1" name="Trauma"  @foreach ($formData as $item)
        @if ($item->fieldName == 'Trauma' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Trauma' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach >         
    </div> 
     <div class="col-md-2 mt-2">
        <label class="gender form-label"> Trauma</label> 
    </div> 
</div> 
</div>

<div class="row Anyother">
    <div class="col-md-1 mt-3">
        <label class="gender form-label"> Any other:</label>      
    </div>
    <div class="col-md-11 mt-2">
        @foreach($formData as $item)
            @if($item->fieldName == 'Anyother')
                <input type="text" class="in1" name="Anyother" value="{{trim($item->fieldValue)}}">
            @break
        @endif
    @endforeach
    </div>
</div>

<div class="history">
    <div class="pains">
    <div class="row">  
        <div class=" col-md-2 mt-2">
            <h4  >History of Pain:</h4>           
        </div>
        <div class="col-md-1 mt-3">
            <label class="gender form-label in1" style="margin-left: -25px;"> Duration:</label>         
        </div>
  <div class="col-md-2 mt-2"> <input type="text" name="Duration" value="@foreach($formData as $item)<?php if($item->fieldName == 'Duration') { echo trim($item->fieldValue); break; } ?>@endforeach" class="in1" style="margin-left: -35px;"></div>     
  <div class="col-md-1 mt-3"><label class="gender form-label"> Occurs/Aggravates:</label></div>
</div>


<div class="row">   
  
    <div class="col-md-2">    
    </div>
    <div class="col-md-1">    
    </div>
     <div class="col-md-1">
        <label class="gender form-label"> Continous</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Continous' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Continous' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1 col-md-" name="Continous">       
    </div> 
    
     <div class="col-md-1">
        <label class="gender form-label"> Sharp</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'Sharp' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Sharp' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Sharp">         
    </div> 
   
     <div class="col-md-auto">
        <label class="gender form-label"> Only on Stimulus</label> 
    </div> 
    <div class="d-flex col-md-1">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'Stimulus' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Stimulus' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Stimulus">         
    </div>  
</div> 
<div class="row">   
    <div class="col-md-2">    
    </div>
    <div class="col-md-1">    
    </div> 
     <div class="col-md-1">
        <label class="gender form-label"> Intermittent</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Intermittent' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Intermittent' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1 col-md-" name="Intermittent">       
    </div>
     <div class="col-md-1">
        <label class="gender form-label"> Dull</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Dull' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Dull' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1" name="Dull">         
    </div> 
     <div class="col-md-auto">
        <label class="gender form-label space"> Spontaneous</label> 
    </div>
    <div class="d-flex col-md-1">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Spontaneous' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Spontaneous' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" style="margin-left: 36px;" name="Spontaneous">         
    </div>      
</div> 
<div class="row">
    <div class="col-md-2">    
    </div>
    <div class="col-md-1">    
    </div> 
    <div class="col-md-1">
        <label class="gender form-label"> Localized</label> 
    </div>
    <div class="d-flex col-md-8">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Localized' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Localized' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1 col-md-" name="Localized">       
    </div> 
    
</div>
<div class="row">
    <div class="col-md-2">    
    </div>
    <div class="col-md-1">    
    </div> 
    <div class="col-md-1">
        <label class="gender form-label"> Radiating</label> 
    </div>
    <div class="d-flex col-md-8">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Radiating' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Radiating' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1 col-md-" name="Radiating">       
    </div>   
</div>
</div>

<div class="row Factors">        
    <div class=" col-md-2 mt-3" >
        <label class="gender form-label" style="margin-left: -45px;"> Agrravating Factors: </label>              
    </div>
<div class="col-md-3 mt-2"> <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'AgrravatingFactors')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" name="AgrravatingFactors" class="in1 " style="margin-left: -80px;"></div> 
<div class="col-md-2 mt-3"><label class="gender form-label" style="margin-left: -45px;"> Relieving Factors: </label></div>
<div class="col-md-3 mt-2"> <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'RelievingFactors')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" name="RelievingFactors" class="in1" style="margin-left: -95px;"></div> 
</div>

<div class="PreComplaints">
<div class="row">
<h3>History of Presenting Complaints:</h3>
</div>
<div class="row">
<div class="col-md-12 mt-2"> <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'HistoryofPresentingComplaints')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" name="HistoryofPresentingComplaints" class="in1"></div> 
</div>
</div>
<div class="habits">
<div class="row">
    <h3>Habits:</h3>
</div>

<div class="row">   
  
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Chalia' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Chalia' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach type="checkbox" class="check_box1 col-md-1" name="Chalia">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Chalia</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Smoking' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Smoking' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Smoking">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Smoking</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Naswar' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Naswar' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Naswar">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label">Naswar</label> 
    </div>  
</div>

<div class="row">     
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Paan' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Paan' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1 col-md-1" name="Paan">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Paan</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'Tobacco' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Tobacco' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Tobacco">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Tobacco</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Alcohol' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Alcohol' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Alcohol">         
    </div> 
     <div class="col-md-auto">
        <label class="gender form-label">Alcohol</label> 
    </div>  
</div>
<div class="row">     
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'Braxium' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Braxium' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1 col-md-" name="Braxium">       
    </div> 
     <div class="col-md-auto">
        <label class="gender form-label"> Braxium</label> 
    </div>   
</div>
</div>
<div class="medical">
<div class="row">
<h3>Medical Profile:</h3>
</div>

<div class="row">     
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Pregnancy' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Pregnancy' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1 col-md-" name="Pregnancy">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Pregnancy</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Asthama' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Asthama' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Asthama">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Asthama</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Epilepsy' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Epilepsy' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Epilepsy">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label">Epilepsy</label> 
    </div>  
</div>

<div class="row">     
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'HypertensionProfile' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'HypertensionProfile' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1 col-md-" name="HypertensionProfile">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Hypertension</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'Tuberculosis' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Tuberculosis' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Tuberculosis">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Tuberculosis</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'CerebrovascularAccident' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'CerebrovascularAccident' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1" name="CerebrovascularAccident">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label">Cerebrovascular Accident</label> 
    </div>  
</div>

<div class="row">     
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'DiabetesMellittus' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'DiabetesMellittus' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1 col-md-" name="DiabetesMellittus">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Diabetes Mellittus</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'PepticUlcerDisease' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'PepticUlcerDisease' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="PepticUlcerDisease">         
    </div> 
     <div class="col-md-auto">
        <label class="gender form-label"> Peptic Ulcer Disease</label> 
    </div> 
</div>


<div class="row">     
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'IschemicHeartDisease' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'IschemicHeartDisease' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1 col-md-" name="IschemicHeartDisease">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Ischemic Heart Disease</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'RenalDisease' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'RenalDisease' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1" name="RenalDisease">         
    </div> 
     <div class="col-md-auto">
        <label class="gender form-label"> Renal Disease</label> 
    </div> 
</div>
<div class="row">     
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'ValvularHeartDisease' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'ValvularHeartDisease' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1 col-md-" name="ValvularHeartDisease">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label">Valvular Heart Disease</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input @foreach ($formData as $item)
        @if ($item->fieldName == 'Arthritis' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Arthritis' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1" name="Arthritis">         
    </div> 
     <div class="col-md-auto">
        <label class="gender form-label"> Arthritis</label> 
    </div> 
</div>

<div class="row">     
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'BleedingDisorder' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'BleedingDisorder' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1 col-md-" name="BleedingDisorder">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label">Bleeding Disorder</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'SkinDisease' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'SkinDisease' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="SkinDisease">         
    </div> 
     <div class="col-md-auto">
        <label class="gender form-label"> Skin Disease</label> 
    </div> 
</div>
<div class="row">     
    <div class="d-flex col-md-auto">
        <input @foreach ($formData as $item)
        @if ($item->fieldName == 'Hepatitis' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Hepatitis' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1 col-md-" name="Hepatitis">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label">Hepatitis</label> 
    </div>
    <div class="d-flex col-md-auto">
        <input   @foreach ($formData as $item)
        @if ($item->fieldName == 'ThyroidDisorder' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'ThyroidDisorder' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1" name="ThyroidDisorder">         
    </div> 
     <div class="col-md-auto">
        <label class="gender form-label"> Thyroid Disorder</label> 
    </div> 
</div>
</div>

<div class="row previous">
    <div class="col-md-2 mt-3">
        <label class=" form-label"> Previous Hospitalization: </label>         
    </div>
    <div class="col-md-3 mt-2">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'PreviousHospitalization' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'PreviousHospitalization' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="text" class="in1" name="PreviousHospitalization" style="margin-left: -40px;">
    </div>
</div>

<div class="row transfusion">
    <div class="col-md-2 mt-3">
        <label class=" form-label"> Transfusion History:</label>       
    </div>
<div class="d-flex col-md-auto mt-2">
    <input  @foreach ($formData as $item)
    @if ($item->fieldName == 'Donor' && $item->fieldValue == '1')
            value="1"
            checked
            @break
    @elseif($item->fieldName == 'Donor' && $item->fieldValue == '0')
            value="0"
            @break
    @endif
@endforeach type="checkbox" class="check_box1" name="Donor">         
</div>     
<div class="col-md-auto mt-3">
    <label class="gender form-label"> Donor</label> 
</div>   
<div class="d-flex col-md-auto mt-2">
    <input  @foreach ($formData as $item)
    @if ($item->fieldName == 'Recipient' && $item->fieldValue == '1')
            value="1"
            checked
            @break
    @elseif($item->fieldName == 'Recipient' && $item->fieldValue == '0')
            value="0"
            @break
    @endif
@endforeach   type="checkbox" class="check_box1" name="Recipient">         
</div>     
<div class="col-md-auto mt-3">
    <label class="gender form-label"> Recipient</label> 
</div> 
</div>
<div class="row drug">
    <div class="col-md-1 mt-3"><label class="gender form-label"> Drug History </label>     
    </div>
    <div class="col-md-11 mt-2">
        <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'DrugHistory')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" name="DrugHistory" class="in1">
    </div>
</div>
<div class="row allergies">
    <div class="col-md-1 mt-3"><label class="gender form-label"> Allergies </label>   
    </div>
    <div class="col-md-11 mt-2">
        <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'Allergies')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" name="Allergies" class="in1">
    </div>
</div>

<div class="family-history">
<div class="row ">
    <h3>Family History:</h3>
</div>
<div class="row">   
    <div class="d-flex col-md-1">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Diabetes' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Diabetes' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1 col-md-" name="Diabetes">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Diabetes</label> 
    </div>
    <div class="col-md-2">
        <label class="gender form-label">M/F/B/S</label>   
    </div>
    <div class="d-flex col-md-1">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'Ihd' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'Ihd' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="Ihd">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> IHD</label> 
    </div> 
    <div class="col-md-2">
        <label class="gender form-label">M/F/B/S</label>   
    </div>
</div>
<div class="row">   
  
    <div class="d-flex col-md-1">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'HypertensionHistory' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'HypertensionHistory' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach   type="checkbox" class="check_box1 col-md-" name="HypertensionHistory">       
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Hypertension</label> 
    </div>
    <div class="col-md-2">
        <label class="gender form-label">M/F/B/S</label>   
    </div>
    <div class="d-flex col-md-1">
        <input  @foreach ($formData as $item)
        @if ($item->fieldName == 'BleedingDisorder2' && $item->fieldValue == '1')
                value="1"
                checked
                @break
        @elseif($item->fieldName == 'BleedingDisorder2' && $item->fieldValue == '0')
                value="0"
                @break
        @endif
    @endforeach  type="checkbox" class="check_box1" name="BleedingDisorder2">         
    </div> 
     <div class="col-md-3">
        <label class="gender form-label"> Bleeding Disorder</label> 
    </div> 
    <div class="col-md-2">
        <label class="gender form-label">M/F/B/S</label>   
    </div>
</div>
</div>

<!-- second form Start  -->
<div class="Extra-Oral">
<div class="container mt-3">
    <!-- <div class="row mt-2"> -->
        <div class="row ">
            <h3 style="margin-left: -34px;">Extra Oral Examination:</h3>
        </div>
    </div> 
    <div class="row mt-1">     
     <div class="d-flex col-md-auto">
         <input  @foreach ($formData as $item)
         @if ($item->fieldName == 'Anemia' && $item->fieldValue == '1')
                 value="1"
                 checked
                 @break
         @elseif($item->fieldName == 'Anemia' && $item->fieldValue == '0')
                 value="0"
                 @break
         @endif
     @endforeach   type="checkbox" class="check_box1" name="Anemia">       
     </div> 
      <div class="col-md-2">
         <label class="gender mt-2 form-label"> Anemia</label> 
     </div>
     <div class="d-flex col-md-auto">
         <input   @foreach ($formData as $item)
         @if ($item->fieldName == 'Swelling' && $item->fieldValue == '1')
                 value="1"
                 checked
                 @break
         @elseif($item->fieldName == 'Swelling' && $item->fieldValue == '0')
                 value="0"
                 @break
         @endif
     @endforeach  type="checkbox" class="check_box1" name="Swelling">         
     </div> 
      <div class="col-md-2 mt-2 form-label">
         <label class="gender"> Swelling</label> 
     </div>
 </div> 
 <div class="row mt-1">     
     <div class="d-flex col-md-auto">
         <input   @foreach ($formData as $item)
         @if ($item->fieldName == 'Jaundice' && $item->fieldValue == '1')
                 value="1"
                 checked
                 @break
         @elseif($item->fieldName == 'Jaundice' && $item->fieldValue == '0')
                 value="0"
                 @break
         @endif
     @endforeach  type="checkbox" class="check_box1" name="Jaundice">       
     </div> 
      <div class="col-md-2">
         <label class="gender mt-2 form-label"> Jaundice</label> 
     </div>
     <div class="d-flex col-md-auto">
         <input  @foreach ($formData as $item)
         @if ($item->fieldName == 'FacialAsymmetry' && $item->fieldValue == '1')
                 value="1"
                 checked
                 @break
         @elseif($item->fieldName == 'FacialAsymmetry' && $item->fieldValue == '0')
                 value="0"
                 @break
         @endif
     @endforeach  type="checkbox" class="check_box1" name="FacialAsymmetry">         
     </div> 
      <div class="col-md-2 mt-2 form-label">
         <label class="gender"> Facial Asymmetry</label> 
     </div>
 </div> 
 
 <div class="row mt-1">     
     <div class="col-md-auto">
        <label class="gender">Note:</label> 
     </div>
     <div class="col-md-11">
        <input  value="@foreach($formData as $item)@if($item->fieldName == 'note'){{trim($item->fieldValue)}}@break @endif @endforeach"  type="text" name="note" style="width: 100%;" class="in1">
     </div>
 </div>
</div>
 <!-- <div class="row mt-1">     
     <div class="col-lg-12" >
         <span class="in1"></span>
     </div>
 </div> -->
 
 <div class="row mt-3">
          <div class="col-lg-7">
              <h4 class="siteTitle">Intra Oral Examination:</h4><br>

        <div class="row">
            <div class="col-md-12 p-0 m-0">
                <table class="table-striped">
                    <tr class="">
                      <th><input
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child1')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach"
                        type="text" name="child1" id="" class="form-control" style="border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child2')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child2" id="" class="form-control" style="border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child3')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child3" id="" class="form-control" style="border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child4')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child4" id="" class="form-control" style="border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child5')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child5" id="" class="form-control" style="width:50px; border-right:1px solid black; border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child6')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child6" id="" class="form-control" style="border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child7')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child7" id="" class="form-control" style="border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child8')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child8" id="" class="form-control" style="border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child9')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child9" id="" class="form-control" style="border-radius: 0;"></th>
                      <th><input type="text" 
                        value="@foreach($formData as $item)
                        @if($item->fieldName == 'child10')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" name="child10" id="" class="form-control" style="border-radius: 0;"></th>
                    </tr>
                    <tr class="">
                      <td><img src="{{ asset('images/DentalForm/t1-removebg-preview.png') }}" style="width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t2-removebg-preview.png') }}" style="width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t3-removebg-preview.png') }}" style="width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t4-removebg-preview.png') }}" style="width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t5-removebg-preview.png') }}" style="border-right:1px solid black; width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t6-removebg-preview.png') }}" style="width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t7-removebg-preview.png') }}" style="width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t8-removebg-preview.png') }}" style="width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t9-removebg-preview.png') }}" style="width:50px; height:120px;"></td>
                      <td><img src="{{ asset('images/DentalForm/t10-removebg-preview.png') }}"style="width:50px; height:120px;"></td>
                    </tr>

                    <tr class="">
                        <th><img src="{{ asset('images/DentalForm/t11-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t12-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t13-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t14-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t15-removebg-preview.png') }}" style="border-right:1px solid black; width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t16-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t17-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t18-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t19-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                        <th><img src="{{ asset('images/DentalForm/t20-removebg-preview.png') }}" style="width:50px; height:120px;"></th>
                      </tr>

                      <tr class="">
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child11')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child11" id="" class="form-control" style="border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child12')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child12" id="" class="form-control" style="border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child13')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child13" id="" class="form-control" style="border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child14')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child14" id="" class="form-control" style="border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child15')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child15" id="" class="form-control" style="width:50px; border-right:1px solid black; border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child16')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child16" id="" class="form-control" style="border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child17')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child17" id="" class="form-control" style="border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child18')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child18" id="" class="form-control" style="border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child19')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child19" id="" class="form-control" style="border-radius: 0;"></td>
                        <td><input
                            value="@foreach($formData as $item)
                        @if($item->fieldName == 'child20')
                            {{trim($item->fieldValue)}}
                            @break
                        @endif
                        @endforeach" type="text" name="child20" id="" class="form-control" style="border-radius: 0;"></td>
                      </tr>
                </table>
            </div>
        </div>
        
     </div>
     <div class="col-lg-5">
         <h4 class="key">Key:</h4><br>
         <span>Tooth Absent (X)</span><br>
         <span>Broken Down Roots (BDR)</span><br>
         <span>Grossly Carious (GC)</span><br>
         <span>Tender To Percussion (TTP)</span><br>
         <span>Non Carious Tooth Loss (NC)</span><br>
         <span>Restored (F)</span><br>
         <span>Stains (S)</span><br>
         <span>Fractured (#)</span><br>
         <span>Impacted (IMP)</span><br>
         <h4 class="Prosthesis">Prosthesis:</h4>
         <span>Crown / Bridge</span><br>
         <span>Partial Denture</span><br>
         <h4 class="Prosthesis">Mobility:</h4>
         <span>Grade I (GI)</span><br>
         <span>Grade II (GII)</span><br>
         <span>Grade III (GIII)</span>
     </div>
        </div>



        <div class="row mt-5 pt-5">
            <div class="col-md-12">
                <table>
                    <thead>
                            <tr>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult1')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult1" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult2')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult2" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult3')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult3" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult4')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult4" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult5')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult5" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult6')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult6" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult7')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult7" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult8')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult8" id="" class="form-control" style="border-right:1px solid black; border-radius: 0; width: 65px;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult9')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult9" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult10')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult10" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult11')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult11" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult12')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult12" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult13')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult13" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult14')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult14" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult15')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult15" id="" class="form-control" style="border-radius: 0;"></th>
                                <th><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult16')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult16" id="" class="form-control" style="border-radius: 0;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ asset('images/AdultTeeth/1.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/2.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/3.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/4.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/5.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/6.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/7.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/8.png') }}" style="border-right:1px solid black; width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/9.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/10.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/11.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/12.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/13.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/14.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/15.png') }}" style="width:65px; height:120px;"></td>
                                <td><img src="{{ asset('images/AdultTeeth/16.png') }}" style="width:65px; height:120px;"></td>
                            </tr>
                            <tr>
                                <th><img src="{{ asset('images/AdultTeeth/17.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/18.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/19.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/20.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/21.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/22.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/23.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/24.png') }}" style="border-right:1px solid black; width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/25.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/26.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/27.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/28.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/29.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/30.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/31.png') }}" style="width:65px; height:120px;"></th>
                                <th><img src="{{ asset('images/AdultTeeth/32.png') }}" style="width:65px; height:120px;"></th>
                            </tr>
                            <tr>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult17')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult17" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult18')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult18" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult19')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult19" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult20')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult20" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult21')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult21" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult22')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult22" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult23')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult23" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult24')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult24" id="" class="form-control" style="border-right:1px solid black; width: 65px; border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult25')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult25" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult26')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult26" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult27')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult27" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult28')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult28" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult29')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult29" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult30')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult30" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult31')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult31" id="" class="form-control" style="border-radius: 0;"></td>
                                <td><input
                                    value="@foreach($formData as $item)
                                    @if($item->fieldName == 'adult32')
                                        {{trim($item->fieldValue)}}
                                        @break
                                    @endif
                                    @endforeach"
                                    type="text" name="adult32" id="" class="form-control" style="border-radius: 0;"></td>
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>
 
 <div class="Investigation">
 <div class="row mt-4">
     <div class="col-lg-12">
     <h4>Investigations:</h4>
     </div>
     </div>
 
     
        <div class="row mt-1">     
         <div class="d-flex col-md-auto">
             <input  @foreach ($formData as $item)
             @if ($item->fieldName == 'PAXray' && $item->fieldValue == '1')
                     value="1"
                     checked
                     @break
             @elseif($item->fieldName == 'PAXray' && $item->fieldValue == '0')
                     value="0"
                     @break
             @endif
         @endforeach  type="checkbox" class="check_box1" name="PAXray">       
         </div> 
          <div class="col-md-1">
             <label class="gender mt-2 Note:"> PA X-ray</label> 
         </div>
         <div class="col-md-auto mt-2">
             <input name="PAXray_feild"  value="@foreach($formData as $item)
    @if($item->fieldName == 'PAXray_feild')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" style="width: 250px;" class="in1">
          </div>
         <div class="d-flex col-md-auto">
             <input type="checkbox" class="check_box1 mt-2" name="OPG" @foreach ($formData as $item)
             @if ($item->fieldName == 'OPG' && $item->fieldValue == '1')
                     value="1"
                     checked
                     @break
             @elseif($item->fieldName == 'OPG' && $item->fieldValue == '0')
                     value="0"
                     @break
             @endif
         @endforeach>         
         </div> 
          <div class="col-md-1 ">
             <label class="gender mt-2 form-label"> OPG</label> 
         </div>
         <div class="col-md-auto">
             <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'OPG_feild')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach" name="OPG_feild" type="text" style="width: 250px;" class="in1 mt-2">
          </div> 
 <div class="row">
 
     <div class="col-md-2 ">
         <label class="gender mt-4 form-label"> Dentist Signature:</label> 
     </div>
     <div class="col-md-auto">
         <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'Duration')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" name="DentistSignature" value="@foreach($formData as $item)
@if($item->fieldName == 'DentistSignature')
    {{trim($item->fieldValue)}}
    @break
@endif
@endforeach" style="width: 250px; margin-left: -20px;" class="in1 mt-3">
      </div>
 </div>
</div>

<div class="row">
<div class="col-lx-6 col-lg-6 col-md-6 col-sm-6 col-6">
    <br>
    <label for="exampleInput8">Attach File</label>
    <input name="dentalFormAttachment" type="file" class="form-control " id="exampleInput8"
     @foreach($formData as $item)
                @if($item->fieldName == 'dentalFormAttachment')
                    value="{{trim($item->fieldValue)}}"
                    @break
                @endif
            @endforeach
            >
            <input type="hidden" name="olddentalFormAttachment" 
            @foreach($formData as $item)
                @if($item->fieldName == 'dentalFormAttachment')
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
        @if($item->fieldName == 'dentalFormAttachment')
        <a href="/storage/Attachments/{{ trim($item->fieldValue) }} 
            " target="_blank">Show Attachment</a>
            @break
        @endif
    @endforeach
</div>

</div>

 
 </div>
 </div>
</div>
</div>

@role('Admin|Doctor')
<input class="btn btn-primary" type="submit" value="SAVE" />
@endrole

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
</script>
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

<script>
    let allInput =document.getElementsByTagName("input");
for (let index = 0; index < allInput.length; index++) {
    allInput[index].value = allInput[index].value.trim();
}
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
    //   });
    
</script>


@endsection