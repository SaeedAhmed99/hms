
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400&family=Noto+Sans+Arabic:wght@300&family=Rajdhani:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>


<body>
    <style>
        @page {
            /* dimensions for the whole page */
            size: A5;
            margin: 0;
        }

        html {
            /* off-white, so body edge is visible in browser */
            /* background: #eee; */
            direction: rtl;
            font-family: 'Cairo', sans-serif;
        }

        body {
            /* A5 dimensions */
            /* height: 200mm;
            width: 148.5mm; */
            margin: 0;
            direction: rtl;
            font-family: 'Cairo', sans-serif;
        }
        /* fill half the height with each face */

        .face {
            height: 100%;
            width: 100%;
            position: relative;
        }
        /* the back face */

        .face-back {
            background: #f6f6f6;
        }
        /* the front face */

        .face-front {
            background: #fff;
            padding: 0px 5px;
        }
        /* an image that fills the whole of the front face */

        ul {
            padding: 0px 20px 0px 20px;
            list-style: none;
            display: flex;
            justify-content: space-between;
            text-align: right;
            align-items: center;
            margin: 0;
        }

        ul li {
            text-align: right;
        }

        ul li img {
            width: 40%;
        }

        .servicandtime {
            width: 250px
        }

        .title {
            color: black;
            font-weight: bold !important;
            /* background-color: black; */
            text-align: right;
            /* padding: 3px; */
            /* border-radius: 20px 5px 5px 20px; */
            /* display: block; */
            /* font-weight: lighter; */
            font-size: 40px;
            line-height: 1;
            padding-bottom: 0px;
        }

        .date {
            color: gray;
            font-size: 20px;
            margin-right: 2px;
        }

        .T_num {
            text-align: center !important;
            display: block;
            width: 100%;
            font-weight: bolder;
            font-size: 40px;
        }

        .textCenter {
            text-align: center;
        }

        .T_num_span {
            text-align: center;
            font-weight: bold;
            font-size: 40px;
            width: 100%;
            color: gray;
        }

        table,
        th,
        td {
            direction: rtl;
            text-align: right;
            font-size: 40px;
            line-height: 1.6;
            font-weight: bold;
        }

        hr {
            /* padding: 5px 33px; */
            border-bottom: 3px solid gray;
        }

        .name {
            width: 220px;
        }

        .value {
            font-size: 40px;
            font-weight: lighter;
        }

        @media print {
        #button {
        display: none;
        }
        }

        .infoleft {
            width: 350px;
            text-align: right

        }

        .lable {
            font-size: 30px;
        }

        .right{
            width: 110px !important;
        }

        .left{
            width: 100%px;
        }

        .list {
            font-size: 30px;
        }

        .logo {
            width: 400px
        }

        .textnumber {
            border: dotted 2px black;
            /* border-bottom: dotted 2px black; */
            padding: 0px 10px 0px 10px
        }
    </style>
<div class="m-3" id="button">
    <a href="{{ route('today.appointments') }}" id="backButton" class="btn btn-primary ml-2">Back</a>
    <button class="btn btn-primary" id="printPageButton" onClick="window.print();">Print</button>
</div>
    <div class="face face-front" id="libInp" >

        <ul style="margin-bottom: 30px">
            <li class="servicandtime">
                @php
                    $servicesIds = $appointment->service_id;
                    $gerServices = App\Models\Service::whereIn('id', $servicesIds)->get();
                @endphp
                {{-- <label class="title">{{$appointment->service->name ?? ''}}</label> --}}
                @foreach ($gerServices as $service)
                <label class="title">{{ $service->name . ', ' ?? '' }}</label>
                @endforeach
                <br>
                {{-- <span class="date">{{ now() }}</span> --}}
                <span class="date">#{{ $appointment->patient->user->serial_number ?? '' }}</span>
            </li>
            <li class="logo">
                <img style="width: 100%" src="{{ asset('assets/images/madian.jfif') }}"   >
            </li>
            <li class="textCenter textnumber">
                <label class="T_num">رقم التذكرة</label>
                <span class="T_num_span">{{$appointment->counter}}</span>
            </li>
        </ul>
        {{-- @dd($appointment->patient->user) --}}
        <ul>
            <li>
                <label class="lable right" style="font-weight: bold">المريض: </label>
                <span class="list">{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->middle_name }} {{ $appointment->patient->user->last_name }}</span>
                <br>
                <label class="lable right" style="font-weight: bold">العمر: </label>
                {{-- @dd($appointment->patient->user->age) --}}
                <span class="list">{{ $appointment->patient->user->age }}</span>
                <br>
                <label class="lable right" style="font-weight: bold">التاريخ: </label>
                <span class="list">{{ date('d-m-Y', strtotime($appointment->opd_date)) }}</span>
            </li>

            <li class="textCenter infoleft">
                <label class="lable left" style="font-weight: bold; width: 150px;">نوع الخدمة: </label>
                <span class="list">{{$appointment->service->name ?? ''}}</span>
                <br>
                <label class="lable left" style="font-weight: bold; width: fit-content;">الطبيب: </label>
                <span class="list">{{$appointment->doctor->user->first_name}} {{$appointment->doctor->user->middle_name}} {{$appointment->doctor->user->last_name}}</span>
                <br>
                <label class="lable left" style="font-weight: bold; width: 150px">رقم الجوال: </label>
                <span class="list">{{$appointment->patient->user->phone}}</span>
            </li>
        </ul>
       <hr>
    </div>

    <script>
        function display() {
           window.print();
        }
     </script>
</body>

</html>
