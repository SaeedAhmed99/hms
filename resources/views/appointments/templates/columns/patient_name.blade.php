<div class="d-flex align-items-center">
    <div class="image image-mini me-3">
        {{$row->counter}} - 
    </div>
    <div class="d-flex flex-column">
        <a href="{{route('patients.show',$row->patient->id)}}"
           class="mb-1 text-decoration-none">{{$row->patient->user->first_name}} {{$row->patient->user->middle_name}} {{$row->patient->user->last_name}} @if(count($row->patient->appointments) == 1) <small style="color: green">(new)</small> @endif</a>
        <span>{{$row->patient->patientUser->email}}</span>
    </div>
</div>
