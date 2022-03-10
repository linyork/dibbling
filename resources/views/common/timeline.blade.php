@foreach($list as $key => $val)
@if($key == 0 || !isset($year) || $year != date('Y', strtotime($val['time'])))
    <dt class="dt-year" data-val="{{date('Y', strtotime($val['time']))}}">{{ date('Y', strtotime($val['time'])) }}</dt>
@endif
@if($key == 0 || !isset($month) || $month != date('Ym', strtotime($val['time'])))
    <dt class="dt-month" data-val="{{date('Ym', strtotime($val['time']))}}">{{ date('m', strtotime($val['time'])) }}</dt>
@endif
@php
    $year = date('Y', strtotime($val['time']));
    $month = date('Ym', strtotime($val['time']));
@endphp
<dd class="dd-y-{{$year}} dd-m-{{$month}} pos-{{ $val['action'] == '1' ? 'left' : 'right' }} clearfix">
    <div class="circ circ{{ $val['action'] }} animation"></div>
    <div class="time">{{ date('m-d A h:i', strtotime($val['time'])) }}</div>
    <div class="events">
        <div class="events-header"><li class="fas type{{ $val['action'] }}"></li> {{ $val['name'].' '.$val['record_type'] }}</div>
        <div class="events-body">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-12">
                    <img width="100%" class="events-object img-responsive img-rounded" src="{{ $val['img'] }}" />
                </div>
                <div class="col-md-9 col-sm-8 col-12">
                    <a href="{{ route('dibbling_record', ['user_id'=>$val['user_id']]) }}"><span class="events-title css-list-name">{{ $val['user_name'] }}</span></a>
                    <div class="events-desc css-list-title">{{ $val['title'] }}</div>
                </div>
            </div>
        </div>
        <div class="events-footer"></div>
    </div>
</dd>
@endforeach

@if(count($list) == 0)
    <div data-list="no-data" class="col-12"></div>
@endif
