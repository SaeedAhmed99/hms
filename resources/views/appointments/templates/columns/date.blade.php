<div class="badge bg-light-info">
    {{-- <div class="mb-2">{{ \Carbon\Carbon::parse($row->opd_date)->isoFormat('LT')}}</div>
    <div>{{ \Carbon\Carbon::parse($row->opd_date)->translatedFormat('jS M, Y')}}</div> --}}
    <div>{{date('d-m-Y', strtotime($row->opd_date))}}</div>
</div>
