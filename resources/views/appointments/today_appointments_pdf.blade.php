<!doctype html>
<html lang="ar">
  <head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
      * {font-family: 'almarai', sans-serif;}
      
      .rwd-table {
        margin: auto;
        min-width: 300px;
        max-width: 100%;
        border-collapse: collapse;
      }
      
      .rwd-table tr:first-child {
        border-top: none;
        background: #428bca;
        color: #fff;
      }
      
      .rwd-table tr {
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        background-color: #f5f9fc;
      }
      
      .rwd-table tr:nth-child(odd):not(:first-child) {
        background-color: #ebf3f9;
      }
      
      .rwd-table th {
        display: none;
      }
      
      .rwd-table td {
        display: block;
      }
      
      .rwd-table td:first-child {
        margin-top: .5em;
      }
      
      .rwd-table td:last-child {
        margin-bottom: .5em;
      }
      
      .rwd-table td:before {
        content: attr(data-th) ": ";
        font-weight: bold;
        width: 120px;
        display: inline-block;
        color: #000;
      }
      
      .rwd-table th,
      .rwd-table td {
        text-align: left;
      }
      
      .rwd-table {
        color: #333;
        border-radius: .4em;
        overflow: hidden;
      }
      
      .rwd-table tr {
        border-color: #bfbfbf;
      }
      
      .rwd-table th,
      .rwd-table td {
        padding: .5em 1em;
      }
      @media screen and (max-width: 601px) {
        .rwd-table tr:nth-child(2) {
          border-top: none;
        }
      }
      @media screen and (min-width: 600px) {
        .rwd-table tr:hover:not(:first-child) {
          background-color: #d8e7f3;
        }
        .rwd-table td:before {
          display: none;
        }
        .rwd-table th,
        .rwd-table td {
          display: table-cell;
          padding: .25em .5em;
        }
        .rwd-table th:first-child,
        .rwd-table td:first-child {
          padding-left: 0;
        }
        .rwd-table th:last-child,
        .rwd-table td:last-child {
          padding-right: 0;
        }
        .rwd-table th,
        .rwd-table td {
          padding: 1em !important;
        }
      }
      
      /* Basic Styling */
      body {
      /* background: #4B79A1;
      background: -webkit-linear-gradient(to left, #4B79A1 , #283E51);
      background: linear-gradient(to left, #4B79A1 , #283E51);         */
      }
      h1 {
        text-align: center;
        font-size: 2.4em;
        color: #f2f2f2;
      }
      .container {
        display: block;
        text-align: center;
      }
      h3 {
        display: inline-block;
        position: relative;
        text-align: center;
        font-size: 1.5em;
        color: #cecece;
      }
      h3:before {
        content: "\25C0";
        position: absolute;
        left: -50px;
        -webkit-animation: leftRight 2s linear infinite;
        animation: leftRight 2s linear infinite;
      }
      h3:after {
        content: "\25b6";
        position: absolute;
        right: -50px;
        -webkit-animation: leftRight 2s linear infinite reverse;
        animation: leftRight 2s linear infinite reverse;
      }
      @-webkit-keyframes leftRight {
        0%    { -webkit-transform: translateX(0)}
        25%   { -webkit-transform: translateX(-10px)}
        75%   { -webkit-transform: translateX(10px)}
        100%  { -webkit-transform: translateX(0)}
      }
      @keyframes leftRight {
        0%    { transform: translateX(0)}
        25%   { transform: translateX(-10px)}
        75%   { transform: translateX(10px)}
        100%  { transform: translateX(0)}
      }
      .invoice-box {
          max-width: 800px;
          margin: auto;
          padding: 30px;
          border: 1px solid #eee;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
          font-size: 16px;
          line-height: 24px;
          font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
          color: #555;
      }
      
      .invoice-box table {
          width: 100%;
          line-height: inherit;
          text-align: left;
          border-collapse: collapse;
      }
      
      .invoice-box table td {
          padding: 5px;
          vertical-align: top;
      }
      
      .invoice-box table tr td:nth-child(2) {
          text-align: right;
      }
      
      .invoice-box table tr.top table td {
          padding-bottom: 20px;
      }
      
      .invoice-box table tr.top table td.title {
          font-size: 45px;
          line-height: 45px;
          color: #333;
      }
      
      .invoice-box table tr.information table td {
          padding-bottom: 40px;
      }
      
      .invoice-box table tr.heading td {
          background: #eee;
          border-bottom: 1px solid #ddd;
          font-weight: bold;
      }
      
      .invoice-box table tr.details td {
          padding-bottom: 20px;
      }
      
      .invoice-box table tr.item td {
          border-bottom: 1px solid #eee;
      }
      
      .invoice-box table tr.item.last td {
          border-bottom: none;
      }
      
      .invoice-box table tr.total td:nth-child(2) {
          border-top: 2px solid #eee;
          font-weight: bold;
      }
      
      @media only screen and (max-width: 600px) {
          .invoice-box table tr.top table td {
              width: 100%;
              display: block;
              text-align: center;
          }
      
          .invoice-box table tr.information table td {
              width: 100%;
              display: block;
              text-align: center;
          }
      }
      
      </style>
   </head>
  <body>
    <div class="invoice-box">
        <table>
            <tr class="information">
                <td colspan="2">
                    <table style="font-family: 'almarai', sans-serif;">
                        <tr>
                            <td style="text-align: center;">
                                    
                                    <br />
                                     <br /><br />
                                      Daily Appointments<br/>
                                     {{ \Carbon\Carbon::parse(now())->format('d-m-Y') }}<br/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <table class="rwd-table" style="width: 100%;">
            <tbody>
                <tr>
                    <th style="font-family: 'almarai', sans-serif;text-align:center; width:10px; color: black;">status</th>
                    <th style="font-family: 'almarai', sans-serif;text-align:center; color: black;">time</th>
                    <th style="font-family: 'almarai', sans-serif;text-align:center; color: black;">service</th>
                    <th style="font-family: 'almarai', sans-serif;text-align:center; color: black;">fees</th>
                    <th style="font-family: 'almarai', sans-serif;text-align:center; color: black;">doctor</th>
                    <th style="font-family: 'almarai', sans-serif;text-align:center; color: black;">patient name</th>
                    <th style="font-family: 'almarai', sans-serif;text-align:center; color: black;">#</th>
                </tr>
                @forelse($appointments as $item)
                    <tr>
                        <td>
                          @if ($item->is_completed == 0)
                          pending
                          @elseif ($item->is_completed == 1)
                          compelted
                          @elseif ($item->is_completed == 3)
                          canceled
                          @endif
                        </td>
                        <td>{{ $item->opd_date }}</td>
                        <td>{{ $item->service->name }}</td>
                        <td>{{ $item->fees }}</td>
                        <td>{{ $item->doctor->user->first_name }} {{ $item->doctor->user->middle_name }} {{ $item->doctor->user->last_name }}</td>
                        <td>{{ $item->patient->user->first_name }} {{ $item->patient->user->middle_name }} {{ $item->patient->user->last_name }}</td>
                        <td>{{ $loop->iteration  }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div>
                                <h1>not found data</h1>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <table style="margin-top: 20px; font-weight: bold; font-size: 20px">
          <tr class="information">
              <td colspan="2">
                  <table style="font-family: 'almarai', sans-serif;">
                      <tr>
                         <td>Total: {{ $appointments->sum('fees') }}</td>
                      </tr>
                  </table>
              </td>
          </tr>
      </table>
        <br/><br/><br/><br/>

    </div>
  </body>
</html>
