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
    <form action="{{request()->url()}}" method="POST">
        @csrf
    <!-- Site title -->
<div class="mainForm">
<div class="container text-center">
    <h3 class="siteTitle">WELLNESS PK</h3>
    <span class="sitePara underline">Plot No.35/135, CP & Berar Cooperating Housing Society, PECHS Block Block 7/8 Karachi East</span>
</div>

<!-- patient details -->
<div class="text_start">
<div class="patientDetails card mt-3 ">
    <div class="row ">
        <div class="d-flex col-md-6 mt-2 ">
            <h5 class="date ">Date:</h5>
            <input type="date" name="dates" style="margin-left: 35px;" id="dates" value="@foreach($formData as $item)
            @if($item->fieldName == 'dates')
                {{trim($item->fieldValue)}}
                @break
           
            @endif
        @endforeach">
    </div>
        <div class="col-md-2 mt-2">
            Dentist Name:   
        </div>
        <div class="col-md-4"> <input type="text" name="dentist_name" value="@foreach($formData as $item)
            @if($item->fieldName == 'dentist_name')
                {{trim($item->fieldValue)}}
                @break
            @endif
        @endforeach" class="in1" style="margin-left: -85px;"></div>
    </div>

    <div class="row" >
        <div class="col-md-1">
            <h5 class="age mt-3"> Name:</h5>
        </div>
        <div class="d-flex col-md-auto" id="nameinp" style="margin-left: -55px;">
     <input type="text" style="margin-left: 28px;  width: 600px;" class="mt-3" name="name" readonly value="{{$patientData->user->full_name }}">
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-auto">
            <h5 class="gender mt-2"> Age:</h5> 
        </div>
        <div class="d-flex col-md-1 mt-2">
         <input type="number" style="margin-left: 15px;" readonly name="age" value="{{$age }}">   
        </div> 


        <div class="col-md-auto">
            <h5 class="gender mt-2" style="margin-left: 125px;"> Gender:</h5>
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
            <h5 class="male mt-2" style="margin-left: -15px;"> Male:</h5>
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
            <h5 class="female mt-2" > Female:</h5>
        </div>
        <div class="col-md-auto">
            <h5 class="mrno mt-2 "> MR No:</h5>
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
            <h5 class="gender"> Pain</h5> 
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
            <h5 class="gender"> Swelling</h5> 
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
            <h5 class="gender"> Malocclusion</h5> 
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
            <h5 class="gender"> Replace missing Teeth</h5> 
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
        <h5 class="gender mt-4"> Mobility</h5> 
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
        <h5 class="gender mt-4"> Food Impaction</h5> 
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
        <h5 class="gender mt-4"> Aesthetics</h5> 
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
        <h5 class="gender mt-3"> Limited Mouth Opening</h5> 
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
        <h5 class="gender mt-2"> Bleeding Gums</h5> 
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
        <h5 class="gender mt-2"> Sensitivity</h5> 
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
        <h5 class="gender mt-2"> Fracture</h5> 
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
        <h5 class="gender mt-2"> Prostheris</h5> 
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
        <h5 class="gender mt-2"> Caries</h5> 
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
     <div class="col-md-2 mt-2">
        <h5 class="gender"> Staining</h5> 
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
        <h5 class="gender"> Trauma</h5> 
    </div> 
</div> 
</div>

<div class="row Anyother">
    <div class="col-md-1 mt-3">
       Any other:   
    </div>
    <div class="col-md-11 mt-2">
        <input type="text" class="in1" name="Anyother" value="@foreach($formData as $item)
        @if($item->fieldName == 'Anyother')
            {{trim($item->fieldValue)}}
            @break
        @endif
    @endforeach">
    </div>
</div>

<div class="history">
    <div class="pains">
    <div class="row">  
        <div class=" col-md-2 mt-2">
            <h4  >History of Pain:</h4>           
        </div>
        <div class="col-md-1 mt-3">
            Duration: 
        </div>
  <div class="col-md-2 mt-2"> <input type="text" name="Duration" value="@foreach($formData as $item)
    @if($item->fieldName == 'Duration')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach" class="in1" style="margin-left: -35px;"></div> 
  <div class="col-md-1 mt-3"><p>Occurs/Aggravates:</p></div>
</div>


<div class="row">   
  
    <div class="col-md-2">    
    </div>
    <div class="col-md-1">    
    </div>
     <div class="col-md-1">
        <h5 class="gender"> Continous</h5> 
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
        <h5 class="gender"> Sharp</h5> 
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
        <h5 class="gender"> Only on Stimulus</h5> 
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
        <h5 class="gender"> Intermittent</h5> 
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
        <h5 class="gender"> Dull</h5> 
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
        <h5 class="gender"> Spontaneous</h5> 
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
        <h5 class="gender"> Localized</h5> 
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
        <h5 class="gender"> Radiating</h5> 
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
        Agrravating Factors:           
    </div>
<div class="col-md-3 mt-2"> <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'AgrravatingFactors')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" name="AgrravatingFactors" class="in1" style="margin-left: -80px;"></div> 
<div class="col-md-2 mt-3"><p>Relieving Factors:</p></div>
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
        <h5 class="gender"> Chalia</h5> 
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
        <h5 class="gender"> Smoking</h5> 
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
        <h5 class="gender">Naswar</h5> 
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
        <h5 class="gender"> Paan</h5> 
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
        <h5 class="gender"> Tobacco</h5> 
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
        <h5 class="gender">Alcohol</h5> 
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
        <h5 class="gender"> Braxium</h5> 
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
        <h5 class="gender"> Pregnancy</h5> 
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
        <h5 class="gender"> Asthama</h5> 
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
        <h5 class="gender">Epilepsy</h5> 
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
        <h5 class="gender"> Hypertension</h5> 
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
        <h5 class="gender"> Tuberculosis</h5> 
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
        <h5 class="gender">Cerebrovascular Accident</h5> 
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
        <h5 class="gender"> Diabetes Mellittus</h5> 
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
        <h5 class="gender"> Peptic Ulcer Disease</h5> 
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
        <h5 class="gender"> Ischemic Heart Disease</h5> 
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
        <h5 class="gender"> Renal Disease</h5> 
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
        <h5 class="gender">Valvular Heart Disease</h5> 
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
        <h5 class="gender"> Arthritis</h5> 
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
        <h5 class="gender">Bleeding Disorder</h5> 
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
        <h5 class="gender"> Skin Disease</h5> 
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
        <h5 class="gender">Hepatitis</h5> 
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
        <h5 class="gender"> Thyroid Disorder</h5> 
    </div> 
</div>
</div>

<div class="row previous">
    <div class="col-md-2 mt-3">
       Previous Hospitalization:  
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
       Transfusion History:  
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
    <h5 class="gender"> Donor</h5> 
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
    <h5 class="gender"> Recipient</h5> 
</div> 
</div>
<div class="row drug">
    <div class="col-md-1 mt-3">
       Drug History 
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
    <div class="col-md-1 mt-3">
      Allergies
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
        <h5 class="gender"> Diabetes</h5> 
    </div>
    <div class="col-md-2">
        <h5 class="gender">M/F/B/S</h5>   
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
        <h5 class="gender"> IHD</h5> 
    </div> 
    <div class="col-md-2">
        <h5 class="gender">M/F/B/S</h5>   
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
        <h5 class="gender"> Hypertension</h5> 
    </div>
    <div class="col-md-2">
        <h5 class="gender">M/F/B/S</h5>   
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
        <h5 class="gender"> Bleeding Disorder</h5> 
    </div> 
    <div class="col-md-2">
        <h5 class="gender">M/F/B/S</h5>   
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
         <h5 class="gender mt-2"> Anemia</h5> 
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
      <div class="col-md-2 mt-2">
         <h5 class="gender"> Swelling</h5> 
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
         <h5 class="gender mt-2"> Jaundice</h5> 
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
      <div class="col-md-2 mt-2">
         <h5 class="gender"> Facial Asymmetry</h5> 
     </div>
 </div> 
 
 <div class="row mt-1">     
     <div class="col-md-auto">
         <h6>Note:</h6>
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
         <img src="Screenshot (2).png" width="90%" height="90%" alt="">
     </div>
     <div class="col-lg-5">
         <h4 class="key">Key:</h4><br>
         <span>Tooth Absent (X)</span><br>
         <span>Broken Down Roots (DDR)</span><br>
         <span>Grossly Carious (GC)</span><br>
         <span>Tender To Percussion (TTP)</span><br>
         <span>Non Carious Tooth Loss (NC)</span><br>
         <span>Restored (F)</span><br>
         <span>Stains (S)</span><br>
         <span>Fractured (F)</span><br>
         <span>Impacted (IMP)</span><br>
         <h4 class="Prosthesis">Prosthesis:</h4>
         <span>Crown / Bridge</span><br>
         <span>Partial Denture</span><br>
         <h4 class="Prosthesis">Mobility:</h4>
         <span>Grade I (GI)</span><br>
         <span>Grade II (GII)</span><br>
         <span>Grade III (GIII)</span>
     </div>
 <div class="row mt-5">
 <div class="col-lg-12">
 <img src="Screenshot (2).png" width="100%"  alt="">
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
             <h5 class="gender mt-2"> PA X-ray</h5> 
         </div>
         <div class="col-md-auto">
             <input name="PAXray_feild"  value="@foreach($formData as $item)
    @if($item->fieldName == 'PAXray_feild')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach"  type="text" style="width: 250px;" class="in1">
          </div>
         <div class="d-flex col-md-auto">
             <input type="checkbox" class="check_box1" name="OPG" @foreach ($formData as $item)
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
          <div class="col-md-1 mt-2">
             <h5 class="gender"> OPG</h5> 
         </div>
         <div class="col-md-auto">
             <input  value="@foreach($formData as $item)
    @if($item->fieldName == 'OPG_feild')
        {{trim($item->fieldValue)}}
        @break
    @endif
@endforeach" name="OPG_feild" type="text" style="width: 250px;" class="in1">
          </div> 
 <div class="row">
 
     <div class="col-md-2 ">
         <h5 class="gender mt-2"> Dentist Signature:</h5> 
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
@endforeach" style="width: 250px; margin-left: -20px;" class="in1">
      </div>
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